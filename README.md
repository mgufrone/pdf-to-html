# PDF to HTML PHP Class

This class brought to you so you can use php and poppler-utils convert your pdf files to html file

## Requirements
1. Poppler-Utils (if you are using Ubuntu Distro, just install it from apt )
	`sudo apt-get install poppler-utils`


## Usage

Here is the sample.

	<?php
	// if you are using composer, just use this
	include 'vendor/autoload.php';

	// if not, use this
	include 'src/Gufy/PdfToHtml.php';

	// initiate 
	$pdf = new \Gufy\PdfToHtml;

	// opening file
	$pdf->open('file.pdf');

	// set different output directory for generated html files
	$pdf->setOutputDirectory('/your/absolute/directory/path');

	// do this if you want to convert in the same directory as file.pdf
	$pdf->generate();

	// you think your generated files is annoying? simple do this to remove the whole files
	$pdf->clearOutputDirectory();
	?>

## Feedback & Contribute

Of course i need feedback to improve this library. Just send an issue, or contribute by pull a request to this repository.
 Thanks

