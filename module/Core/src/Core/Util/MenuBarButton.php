<?php

namespace Core\Util;

class MenuBarButton
{
	protected $name;
	protected $action;
	protected $icon;
	protected $style;

	public function setName($name)
	{
		$this->name = $name;
		return $this;
	}
	public function getName()
	{
		return $this->name;
	}

	public function setAction($action)
	{
		$this->action = $action;
		return $this;
	}
	public function getAction()
	{
		return $this->action;
	}

	public function setIcon($icon)
	{
		$this->icon = $icon;
		return $this;
	}
	public function getIcon()
	{
		return $this->icon;
	}

	public function setStyle($style)
	{
		$this->style = $style;
		return $this;
	}
	public function getStyle()
	{
		return $this->style;
	}
}