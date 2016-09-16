<?php


error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('max_execution_time', 360);


if (!in_array($_SERVER['REMOTE_ADDR'], ['195.244.135.220','87.110.109.53']))
{
    die('no access'.$_SERVER['REMOTE_ADDR']);
}


?>

<form id="form" method="post">
    <input id="command" type="text" name="command" style="width: 400px;">
    <input type="submit">
</form>


<script>
    function submit_command($command) {
        document.getElementById('command').value = $command;
        document.getElementById('form').submit();
    }
</script>

<style>
    ul {
        list-style: none;
        padding: 0;
        height: 20px;
    }

    ul > li {
        float: left;
        margin-right: 16px;
        background-color: greenyellow;
    }
</style>


<ul>
    <li>
        <a href="#" onclick="submit_command('git status')">
            git status
        </a>
    </li>
    <li>
        <a href="#" onclick="submit_command('git pull origin develop')">
            git pull origin develop
        </a>
    </li>
</ul>

<hr>


<?


class ShellRunner
{
    static $result = [];
    static $command = '';


    public static function exec($command)
    {
        self::$command = $command;
        exec($command . ' 2>&1', self::$result);
    }


    public static function dump()
    {
        echo '<h4 style="margin-top: 4px;margin-bottom: 0;padding: 16px; background-color: lightsalmon; border: 1px solid #000000">'
            . self::$command
            . '</h4>';
        echo '<pre style="padding: 16px; background-color: lightgreen; border: 1px solid #000000">';
        ob_start();
        foreach(self::$result as $l)
        {
            echo $l . "\n";
        }
        echo str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), ob_get_clean()) . '</pre>';
    }
}


if(!empty($_POST['command']))
{
    ShellRunner::exec($_POST['command']);
    ShellRunner::dump();
}

// 'git clone git@bitbucket.org:digitalscore/vetfocus.git 2>&1'
