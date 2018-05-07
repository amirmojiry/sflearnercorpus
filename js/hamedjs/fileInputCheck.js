/**
 * 
 */

function fileInputCheck(thisObject, maxSize, fileTypes)
{
	var f = thisObject.files[0];
	var fname = f.name;
	var ftype = fname.substring(fname.lastIndexOf('.') + 1, fname.length);
	var allFileTypes = fileTypes.split(',');
	if (jQuery.inArray(ftype, allFileTypes) == -1)
	{
		alert(" تنها فایل هایی با این پسوند ها مجاز هستند " + fileTypes);
		thisObject.value = null;
	} else
	{
		if (f.size > maxSize || f.fileSize > maxSize)
		{

			alert(" حجم فایل انتخابی شما بیشتر از حجم مجاز برای این بخش است ");
			thisObject.value = null;
		}
	}
}