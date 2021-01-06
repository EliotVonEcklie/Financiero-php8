<?php //V 1000 12/12/16 ?> 
<?php
require_once("HTML_TreeMenuXL\TreeMenuXL.php"); 
    // Create the Menu object and the menu tree
  $menu00  = new HTML_TreeMenuXL();
  $nodeProperties = array("icon"=>"HTML_TreeMenuXL\folder.gif");
  $node0 = new HTML_TreeNodeXL("INBOX", "#", $nodeProperties);
  $nx = &$node0->
    addItem(new HTML_TreeNodeXL("A Folder", "#link1", $nodeProperties));
  $nx = &$nx->
      addItem(new HTML_TreeNodeXL("Nested Folder", "#link2", $nodeProperties));
  $nx = &$nx->
        addItem(new HTML_TreeNodeXL("Deeper ...", "#link3", $nodeProperties));
  $nx = &$nx->
          addItem(new HTML_TreeNodeXL("... and Deeper","#link4", $nodeProperties));
  $node0->addItem(new HTML_TreeNodeXL("deleted-items", "#link5", $nodeProperties));
  $node0->addItem(new HTML_TreeNodeXL("sent-items",    "#link6", $nodeProperties));
  $node0->addItem(new HTML_TreeNodeXL("drafts",        "#link7", $nodeProperties));    
  $node0->addItem(new HTML_TreeNodeXL("spam",          "#link8", $nodeProperties));      
  $menu00->addItem($node0);
  $menu00->addItem(new HTML_TreeNodeXL("My Stuff",     "#link9", $nodeProperties));
  $menu00->addItem(new HTML_TreeNodeXL("Other Stuff",  "#link10", $nodeProperties));
  $menu00->addItem($node0);

  // Menu 1.0
  // Create the presentation object.
  // It will generate HTML and JavaScript for the menu
  // These statements must occur in your HTML exactly where you want the menu to appear.
  $example010 = &new HTML_TreeMenu_DHTMLXL($menu00, array("images"=>"HTML_TreeMenuXL\TMimages"));
  $example010->printMenu();
  
  // Menu 1.1
  // Create another presentation object from the same menu, 
  // but using an alternate image directory
  $example011 = &new HTML_TreeMenu_DHTMLXL($menu00, array("images"=>"HTML_TreeMenuXL\TMimagesAlt"));
  $example011->printMenu();
  
  // Menu 1.2
  $example012 = &new HTML_TreeMenu_DHTMLXL($menu00, array("images"=>"HTML_TreeMenuXL\TMimagesAlt2"));
  $example012->printMenu();
 ?> 