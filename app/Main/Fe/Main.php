<?php 
namespace App\Main\Fe;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use GuzzleHttp\Psr7\Uri;
/**
 * summary
 */
class Main
{
    public function render()
    {
    	$view = new \Rino\Rain\View();

    	$view->vars($set);
        echo $view->see(dirname(__FILE__).DS."tpl".DS."main.html");
    }

}

 ?>