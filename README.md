TableOfContentsX v1.2
=====================

This extra takes your MODX content and creates an ordered list table of contents based on the h1,h2,h3,h4,h5 and h6 tags. This can be used so that long articles and pages can be broken down and makes it easier for the user to click a section they'd like to jump to.



Snippet TableOfContentsX
------------------------

This is the main/only snippet included in this package and takes a template variable/chunk/placeholder and generates the Table Of Contents. The snippet has one parameter and that is to select what it should output:-

* toc - This will output an ordered list with links to your page header tags
* content - This will output your page content with your header tags with anchors

A typical way of using this would be to do the following: -

 [[*content:TableOfContentsX=`toc`]]
 [[*content:TableOfContentsX=`content`]]


Credits
-------

Based on code by Joost de Valk, submitted on 02/08/2011

http://www.westhost.com/contest/php/function/create-table-of-contents/124



Further info
------------

For information and support, check out my blog:

http://www.qodo.co.uk/tableofcontentsx-a-new-modx-extra-for-creating-a-table-of-contents

Created by Stewart Orr @ Qodo Ltd (https://www.qodo.co.uk).