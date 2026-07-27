<?php
namespace xqkeji\app\content\form\template;
class One
{
	public static function getTemplate()
	{
		return '<label class="col-2 col-form-label text-end">
					<?=$text?>
				</label>
				<div class="col-1">
					<?=$content?>
				</div>';
	}
}


