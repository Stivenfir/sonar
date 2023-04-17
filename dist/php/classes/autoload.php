<?php
/*
Using PDFParser without Composer
Folder structure
================
webroot
  pdfdemos
    INV001.pdf # test PDF file to extract text from for demo
    test.php # our operational demo file
  vendor
    autoload.php
    tecnickcom
      tcpdf # unpack v6.2.12 from release at https://github.com/tecnickcom/Excelinsert/archive/6.2.12.tar.gz
    smalot
      pdfparser # unpack from git master https://github.com/PdfParser/archive/master.zip release is 0.9.25 dated 2015-09-15
        docs # optional
        samples # optional
        src
          Smalot
            PdfParser
*/

$vendorDir = '../vendor';
$tcpdf_files = Array(
    'Datamatrix' => $vendorDir . '/phpoffice/include/barcodes/datamatrix.php',
    'PDF417' => $vendorDir . '/phpoffice/include/barcodes/pdf417.php',
    'QRcode' => $vendorDir . '/phpoffice/include/barcodes/qrcode.php',
    'TCPDF' => $vendorDir . '/phpoffice/tcpdf.php',
    'TCPDF2DBarcode' => $vendorDir . '/phpoffice/tcpdf_barcodes_2d.php',
    'TCPDFBarcode' => $vendorDir . '/phpoffice/tcpdf_barcodes_1d.php',
    'TCPDF_COLORS' => $vendorDir . '/phpoffice/include/tcpdf_colors.php',
    'TCPDF_FILTERS' => $vendorDir . '/phpoffice/include/tcpdf_filters.php',
    'TCPDF_FONTS' => $vendorDir . '/phpoffice/include/tcpdf_fonts.php',
    'TCPDF_FONT_DATA' => $vendorDir . '/phpoffice/include/tcpdf_font_data.php',
    'TCPDF_IMAGES' => $vendorDir . '/phpoffice/include/tcpdf_images.php',
    'TCPDF_IMPORT' => $vendorDir . '/phpoffice/tcpdf_import.php',
    'TCPDF_PARSER' => $vendorDir . '/phpoffice/tcpdf_parser.php',
    'TCPDF_STATIC' => $vendorDir . '/phpoffice/include/tcpdf_static.php'
);

foreach ($tcpdf_files as $key => $file) {
    include_once $file;
}

// include_once  $vendorDir . "/PdfParser/src/PdfParser/Parser.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Document.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Header.php";
// include_once  $vendorDir . "PdfParser/src/PdfParser/PDFObject.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Page.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Pages.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementArray.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementBoolean.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementString.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementDate.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementHexa.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementMissing.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementName.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementNull.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementNumeric.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementStruct.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Element/ElementXRef.php";

// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding/StandardEncoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding/ISOLatin1Encoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding/ISOLatin9Encoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding/MacRomanEncoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Encoding/WinAnsiEncoding.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font/FontCIDFontType0.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font/FontCIDFontType2.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font/FontTrueType.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font/FontType0.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/Font/FontType1.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/XObject/Form.php";
// include_once  $vendorDir . "/PdfParser/src/PdfParser/XObject/Image.php";

/*
// Information for comparison with composer
use Datamatrix;
use PDF417;
use QRcode;
use TCPDF;
use TCPDF2DBarcode;
use TCPDFBarcode;
use TCPDF_COLORS;
use TCPDF_FILTERS;
use TCPDF_FONTS;
use TCPDF_FONT_DATA;
use TCPDF_IMAGES;
use TCPDF_IMPORT;
use TCPDF_PARSER;
use TCPDF_STATIC;
*/
