<?php
Yii::import('zii.widgets.grid.CGridColumn');

class SortableGridColumn extends CGridColumn
{
	/**
	 * @var string the attribute name of the data model. The corresponding attribute value will be rendered
	 * in each data cell as the checkbox value. Note that if {@link value} is specified, this property will be ignored.
	 * @see value
	 */
	public $name;
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * in each data cell as the checkbox value. In this expression, you can use the following variables:
	 * <ul>
	 *   <li><code>$row</code> the row number (zero-based)</li>
	 *   <li><code>$data</code> the data model for the row</li>
	 *   <li><code>$this</code> the column object</li>
	 * </ul>
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 */
	public $value;
	/**
	 * @var array the HTML options for the data cell tags.
	 */
	public $htmlOptions=array('class' => 'sortable-handle', 'width' => '30px');
	/**
	 * @var array the HTML options for the header cell tag.
	 */
	public $headerHtmlOptions;
	/**
	 * @var array the HTML options for the footer cell tag.
	 */
	public $footerHtmlOptions;

	/**
	 * Returns the header cell content.
	 * This method will render a checkbox in the header when {@link selectableRows} is greater than 1
	 * or in case {@link selectableRows} is null when {@link CGridView::selectableRows} is greater than 1.
	 * @return string the header cell content.
	 * @since 1.1.16
	 */
	public function getHeaderCellContent()
	{
		return '<i class="fa fa-arrows"></i>';
	}

	/**
	 * Returns the data cell content.
	 * This method renders a checkbox in the data cell.
	 * @param integer $row the row number (zero-based)
	 * @return string the data cell content.
	 * @since 1.1.16
	 */
	public function getDataCellContent($row)
	{
		return $this->id;
	}
}
