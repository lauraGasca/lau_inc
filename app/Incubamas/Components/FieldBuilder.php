<?php namespace Incubamas\Components;

class FieldBuilder
{
    
    protected $defaultClass = [
        'default' =>'',
        'input' => 'input',
        'select' => 'select',
        'textarea' => 'textarea'
    ];
    
    public function getDefaultClass($type)
    {
        if(isset($this->defaultClass[$type]))
        {
            return $this->defaultClass[$type];
        }
        
        return $this->defaultClass['default'];
    }
    
    public function buildCssClasses($type, &$attributes)
    {
        $defaultClasses = $this->getDefaultClass($type);
        
        if(isset($attributes['class']))
        {
            $attributes['class'] .= ' '.$defaultClasses;
        }
        else
        {
            $attributes['class'] = $defaultClasses;
        }
    }
    
    public function buildControl($type, $name, $value=null, $attributes = array(), $options = array())
    {
        switch($type)
        {
            case 'select':
                return \Form::select();
        }
        
    }
    
    public function buildError($name)
    {
        
    }
    
    public function buildTemplate($type)
    {
        
    }
    
    public function input($type, $name, $value=null, $attributes = array(), $options = array())
    {
        $this->buildCssClasses($type, $attributes);
        $control = $this-buildControl($type, $name, $value, $attributes, $options);
        $error = $this->buildError($name);
        $template =$this->buildTemplate($type);
        
        return \View::make($template, compact('name', 'control','error'));
    }
    
    
}