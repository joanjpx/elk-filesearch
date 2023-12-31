<?php

function pptx_to_text($input_file)
{
    $zip_handle  = new \ZipArchive;
    $output_text = "";
    if (true === $zip_handle->open($input_file)) {
        $slide_number = 1; //loop through slide files
        while (($xml_index    = $zip_handle->locateName("ppt/slides/slide".$slide_number.".xml")) !== false) {
            $xml_datas = $zip_handle->getFromIndex($xml_index);

            $doc = new \DOMDocument();

            $doc->loadXML($xml_datas, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $output_text .= strip_tags($doc->saveXML());
            $slide_number++;
        }
        if ($slide_number == 1) {
            $output_text .= "";
        }
        $zip_handle->close();
    } else {
        $output_text .= "";
    }
    return $output_text;
}

echo pptx_to_text($argv[1]);
