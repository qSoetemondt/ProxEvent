<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>navbar demo</title>
  <link rel="stylesheet" href="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
  <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
  <script src="//code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
</head>
<body>
 
<div data-role="page" id="page1">
  <div data-role="header">
    <h1>jQuery Mobile Example</h1>
  </div>
  <div role="main" class="ui-content">
    <p>Some Content here</p>
  </div>
  <div data-role="footer">
    <div data-role="navbar">
      <ul>
        <li><a href="#" class="ui-btn-active">One</a></li>
        <li><a href="#">Two</a></li>
      </ul>
    </div><!-- /navbar -->
  </div><!-- /footer -->
</div><!-- /page -->
</body>
</html>