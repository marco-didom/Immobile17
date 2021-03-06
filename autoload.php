<?php

function my_autoloader($classname)
{
    //echo ("Classe: ".$classname."\n");
    switch ($classname[0])
    {
        case 'M':
            if(strcmp(str_split($classname, 10)[0], "MValidator") === 0)
                include_once('model/validators/' . $classname . '.php');
            else if (strcmp($classname, "MDataChecker") === 0)
                include_once('model/utils/MDataChecker.php');
            else if (strcmp($classname, "MMail") === 0)
                    include_once('model/utils/MMail.php');
            else if(strcmp(str_split($classname, 6)[0], "MMedia") === 0)
                include_once('model/media/' . $classname . ".php");
            else include_once('model/' . $classname . '.php');
            break;
        case 'F':
            if (strcmp(str_split($classname, 6)[0], "FMedia" )===0)
                include_once ('Foundation/FMedia/' . $classname . '.php');
            else include_once('Foundation/' . $classname . '.php');
            break;
        case 'C':
            include_once ('controller/' . $classname . '.php');
            break;
        case 'V':
            include_once ('view/'. $classname . '.php');
            break;
    }
    if($classname === 'OAuth' || strcmp($classname,"PHPMailer") === 0 || $classname === 'POP3' || $classname === 'SMTP')
        include_once ('PHPMailer/src/'.$classname.'.php');


}

spl_autoload_register('my_autoloader');

