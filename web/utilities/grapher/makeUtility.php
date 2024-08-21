<?php

function makeGrapher($name) {
    return [
        'name' => $name,
        'pretty' => 'Grapher',
        'description' => 'This renders the svg for a simple scatter-plot.',
        'background' => 'The main consideration here is the design for each axis.  Each axis should be large enough to contain all of the points, small enough to optimize the page, and the tickmarks should be round numbers.',
        'instructions' => "type <tt>/width/xLabel/showZeroX/height/yLabel/showZeroY/xys</tt>, where <tt>width</tt> and <tt>height</tt> are the graph's dimensions in px, <tt>xLabel</tt> and <tt>yLabel</tt> are self-explanatory, the <tt>showZero</tt> variables are booleans that control whether the graph always includes zero on the particular axis regardless of the values of the points, and <tt>xys</tt> is an array of coordinates. You may express a true boolean by either <tt>true</tt>, <tt>TRUE</tt>, <tt>True</tt>, or <tt>T</tt>, and likewise for false.  <tt>xys</tt> is a comma-separated list of points surrounded by brackets.  Each point is designated by a comma-separated pair of floats surrounded by parentheses.  Use of whitespace is allow for both labels and data points, but its use is discouraged for the latter.  Json is only returned in the case of errors.",
        'examples' => 'TBD.  These should be svgs',
    ];
}
