<?php

namespace App\Fields;

/**
 *
 */
class Select2AjaxChild extends Select2Ajax
{

	protected $parent_selector;
	protected $parent_path;
	protected $child_path;

	public function __construct($model_class, $parent_selector, $parent_path, $child_path, $name = null, $url = null, $value = null, $label = null, $id_property = null, $text_property = null, $note_property = null, $minimum_input_length = null, $tags = false, $delay_ajax = 250, $required = false, $disabled = false, $readonly = false, $options = null)
    {
        parent::__construct($model_class, $name, $parent_path, $value, $label, $id_property, $text_property, $note_property, $minimum_input_length, $tags, $delay_ajax, $required, $disabled, $readonly, $options);

        $this->parent_selector = $parent_selector;
        $this->parent_path = $parent_path;
        $this->child_path = $child_path;

        return $this;
    }

	/**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_filter(array_merge(
            parent::toArray(),
            [
                'field' => 'select2-ajax-child',
                'parent-selector' => $this->parent_selector,
                'parent-path' => $this->parent_path,
                'child-path' => $this->child_path,
            ]
        ));
    }

    /**
     * @param mixed $selector
     * @return Select2AjaxChild
     */
    public function setParentSelector($selector)
    {
        $this->parent_selector = $selector;
        return $this;
    }

    /**
     * @param mixed $path
     * @return Select2AjaxChild
     */
    public function setParentPath($path)
    {
        $this->parent_path = $path;
        return $this;
    }

    /**
     * @param mixed $path
     * @return Select2AjaxChild
     */
    public function setChildPath($path)
    {
        $this->child_path = $path;
        return $this;
    }
}
