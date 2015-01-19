<?php

namespace Core\View\Helper;

use Zend\View\Helper\AbstractHelper;

class MenuBar extends AbstractHelper
{
	public function __invoke($menuItens)
	{
		echo "<div class='col-md-12 alert alert-normal'>";
		foreach ($menuItens as $value) {
			$icon = $value->getIcon() != '' ? $value->getIcon() : '';
			$style = $value->getStyle() != '' ? $value->getStyle() : '';

			$button = "<a class='btn ".$style."' href='".$value->getAction()."'>";
			$button.= "<i class='".$icon."'></i> ".$value->getName()."</a>";
			$button.= "&nbsp;&nbsp;";

      echo $button;
    }
    echo "</div>";
	}
}