function checkboxValidator(checkbox,input)
{
    if(document.getElementById(checkbox).checked)
    {
        document.getElementById(input).disabled = '';
    }
    else
    {
        document.getElementById(input).disabled = 'disabled';
    }
}

function doubleCheckboxValidator(checkbox,input)
{
	if(document.getElementById(checkbox).checked)
    {
        document.getElementById(input).disabled = '';
    }
    else
    {
        document.getElementById(input).disabled = 'disabled';
        document.getElementById(input).checked=false;
    }
}
