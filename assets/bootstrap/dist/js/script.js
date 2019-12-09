function printData(url) {
	var areaPrint = document.getElementById(url);
	newWin = window.open("");
	newWin.document.write(areaPrint.outerHTML);
	newWin.print();
	newWin.close();
}
$('.printContent').on('click', function () {
	var url = $(this).data('url');
	printData(url);
});
