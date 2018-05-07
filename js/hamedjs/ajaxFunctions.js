function academicVerify(btn, thisUserID, thisCourseID, thisverify)
{
	// alert('clicked');
	$.post('includes/postAcademicVerify.php',
	{
		userID : thisUserID,
		courseID : thisCourseID,
		verify : thisverify
	},

	// data is returned in ajax
	function(data)
	{
		// alert(data);
		if (data.indexOf('success') !== -1)
		{
			removeRow(btn);
			alert("انجام شد");
		} else
		{
			alert(data);
		}
	});
};

function moneyVerify(btn, thisUserID, thisCourseID, thisverify)
{
	// alert('clicked');
	$.post('includes/postMoneyVerify.php',
	{
		userID : thisUserID,
		courseID : thisCourseID,
		verify : thisverify
	},

	// data is returned in ajax
	function(data)
	{
		// alert(data);
		if (data.indexOf('success') !== -1)
		{
			removeRow(btn);
			alert("انجام شد");
		} else
		{
			alert(data);
		}
	});
};

function removeRow(btn)
{
	var row = btn.parentNode.parentNode;
	row.parentNode.removeChild(row);
}