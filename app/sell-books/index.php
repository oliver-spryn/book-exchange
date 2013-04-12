<?php
//Verify that the user is logged in
	$essentials->requireLogin();
	$essentials->setTitle("Sell Your Books");
	$essentials->includePluginClass("forms/display/Sell_Book_Display");
	$essentials->includeCSS("styles/sell.css");
	$essentials->includeCSS("styles/bootleg.css");
	
//Instantiate form element display class
	$params = $essentials->params ? $essentials->params[0] : 0;
	$userID = $essentials->user->ID;
	$successRedirect = $essentials->friendlyURL("");
	$failRedirect = $essentials->friendlyURL("sell-books");
	$display = new FFI\BE\Sell_Book_Display($params, $userID, $failRedirect);
	
//Display the page
	echo "<h1>Sell Your Books</h1>
	
<form class=\"form-horizontal\" method=\"post\">\n";

//Display the splash section	
	echo "<section id=\"splash\">
<div class=\"ad-container\">
<div class=\"ad-contents\">
<h2>Sell Your Books</h2>
</div>
</div>
</section>

";
	
//Display the directions
	echo "<section class=\"welcome\">
<h2>Sell Your Books</h2>
<p>If you are interested in selling your book to another student, use this page to post your book. If an individual finds your posting, he or she will be in touch with you to purchase this book.</p>
</section>

";

//Display the book information section
	echo "<section class=\"step stripe\">
<header>
<h2>Book Information</h2>
<h3>We'll need to know a little bit about the book you are selling.</h3>
<h4 class=\"step\">1</h4>
</header>

<div class=\"control-group\">
<label class=\"control-label\" for=\"who\">ISBN-10:</label>
<div class=\"controls\">
" . $display->getISBN10() . "
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"what\">ISBN-13:</label>
<div class=\"controls\">
" . $display->getISBN13() . "
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"when\">Title:</label>
<div class=\"controls\">
" . $display->getTitle() . "
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"where-city\">Author(s):</label>
<div class=\"controls\">
<div class=\"input-append input-prepend\">
" . $display->getAuthors() . "
</div>
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"why\">Edition:</label>
<div class=\"controls\">
" . $display->getEdition() . "
</div>
</div>
</section>

";

//Display the book classes section
	echo "<section class=\"step\">
<header>
<h2>Dependent Courses</h2>
<h3>In which classes did you use this book? Don't bother researching all of the classes which use this book, just tell us the ones where you used it.</h3>
<h4 class=\"step\">2</h4>
</header>

</section>

";

//Display the book information generated by the user section
	echo "<section class=\"step stripe\">
<header>
<h2>The Rest is Up to You</h2>
<h3>We just don't feel as though we've been fully acquainted with your book, yet.</h3>
<h4 class=\"step\">3</h4>
</header>

<div class=\"control-group\">
<label class=\"control-label\" for=\"reimburse\">Price:</label>
<div class=\"controls\">
<div class=\"input-prepend input-append\">
<span class=\"add-on\">\$</span>
" . $display->getPrice() . "
<span class=\"add-on\">.00</span>
</div>
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"why\">Condition:</label>
<div class=\"controls\">
" . $display->getCondition() . "
</div>
</div>

<div class=\"control-group\">
<label class=\"control-label\" for=\"why\">Writing or markings:</label>
<div class=\"controls\">
" . $display->getWriting() . "
</div>
</div>
</section>

";

//Display the comments section
	echo "<section class=\"step\">
<header>
<h2>Closing Thoughts (Optional)</h2>
<h3>Is there anything you'd like to share with your potential buyers?</h3>
<h4 class=\"step\">4</h4>
</header>

<div class=\"control-group\">
<label class=\"control-label\">Comments:</label>
<div class=\"controls\">
" . "
</div>
</div>
</section>

";

//Display the submit button
	echo "<section class=\"no-border step\">
<button class=\"btn btn-primary\" type=\"submit\">Submit Book</button>
<button class=\"btn cancel\" type=\"button\">Cancel</button>
</section>
</form>";
?>