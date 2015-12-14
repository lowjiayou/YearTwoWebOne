<?php
// Include the file for the database connection
include_once('database_conn.php');

// If useXML was sent as part of the url then
if (isset( $_REQUEST['useXML'] )) {
    // echo whatever getXMLOffer returns to the browser or back to the ajax script
    echo getXMLOffer($conn);
} else {    // otherwise just an html record is required

    // So echo whatever getHTMLOffer returns to the browser or back to the ajax script
    echo getHTMLOffer($conn);
}

function getHTMLOffer($connLink) {
    // Store the sql for a random special offer, the sql wraps things using concat in an html 'wrapper'
    $sql1 = "select concat('<p>&#8220;',eventTitle,'&#8221;\n<br/>Category: ',catDesc,'<br/>Price: ',eventPrice,'<br/></p>') as offer FROM te_events_special_offers s inner join te_category c on s.catID = c.catID order by rand() limit 1";

    // execute the query
    $rsOffer = mysqli_query($connLink, $sql1);

    // get the one quotation returned
    $offer = mysqli_fetch_assoc($rsOffer);
    // return the quote
    return $offer['offer'];

}

function getXMLOffer($connLink) {
    $sql2 = "select eventTitle, catDesc, eventPrice FROM te_events_special_offers s inner join te_category c on s.catID = c.catID order by rand() limit 1";
    $xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
    $rsOffer = mysqli_query($connLink, $sql2);
    // start to assemble an output string with the xml head and root element
    $output = $xmlHeader;
    $output .= "<root>\n";
    while ( $record = mysqli_fetch_assoc($rsOffer) ) {
        // start a new record element in xml and add to the output
        $output .= "\t<offer>\n";
        // iterate through each record pulling out the fieldname and its value
        foreach ( $record as $field => $value ) {
            $value = htmlspecialchars( $value );
            // wrap up the fields and values as xml
            $output .= "\t\t<$field>$value</$field>\n";
        }
        $output .= "\t</offer>\n";
    }
    $output .= "</root>";
    return $output;
}
?>