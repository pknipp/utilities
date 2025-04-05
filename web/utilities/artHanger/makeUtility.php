<?php

function makeArtHanger($name) {
    return [
        'name' => $name,
        'pretty' => "Art Hanger",
        'description' => " calculates two asymmetric stud-screw locations when hanging art with a wire.",
        'background' => "The most secure way to mount artwork on a wall is to hang it from a screw mounted on a stud.  However to do this from a <i>single</i> screw would limit you to a discrete set of lateral locations on the wall. This constraint is lifted if your artwork width significantly exceeds the spacing of wall studs (16 inches in the USA).  If so, and if (a) the back of your art has a wire whose ends are attached symmetrically to it, and if (b) you want to hang your art at a location which is neither exactly on a stud nor exactly halfway between studs, then the laws of physics and geometry dictate a difference between the altitudes of the two screws which you sink into the (neighboring) studs.  This app solves the nonlinear equation for that altitude difference.",
        'instructions' => "type <tt>/L/H/W/S/O</tt>, in which each of the five letters represents a positive number as defined below.
        <ul>
        <li> <I>L</I>: total <b>length</b> of the wire running between two symmetrically positionned points on the back of the art</li>
        <li> <I>H</I>: <b>height</b> of the (approximately) top third of the artwork, as defined by the distance between the art's top edge and the horizontal line running between the two points described in the previous line (ie <I>not</I> the substantially larger vertical distance between the art's top and bottom edges)</li>
        <li> <I>W</I>: <b>width</b> of the art, as measured between the two points described in the previous line (ie <I>not</I> the somewhat larger horizontal distance between the art's left and right edges)</li>
        <li> <I>S</I>: <b>stud</b>-spacing, which is 16\" (but sometimes 24\") for the US and 600 mm for some of Europe.</li>
        <li> <I>O</I>: desired <b>offset</b> of the middle of the artwork, as measured horizontally from one of the studs</li>
        </ul>
        <b>NOTE</b> that these instructions do not restrict you to any particular set of units (eg inches or millimeters); you simply need to use the same set for all of your numbers."
        ,
        'examples' => "WIP",
    ];
}
