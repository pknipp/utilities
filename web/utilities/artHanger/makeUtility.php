<?php

function makeArtHanger($name) {
    return [
        'name' => $name,

        'pretty' => "Art Hanger",

        'description' => " calculates stud locations when hanging art asymmetrically with a wire and two screws.",

        'background' => "The most secure way to wall-mount artwork is to suspend it from one or more screws drilled into one or more studs.  However to do this from a <i>single</i> screw would limit you to a discrete set of lateral locations on the wall. This constraint is lifted if your artwork width significantly exceeds the    wall-stud spacing (16 inches in the USA).  If so, and if (a) the back of your art has a wire with ends attached symmetrically to it, and if (b) you want to hang your art at a location which is neither exactly on a stud nor exactly halfway between adjacent studs, then the laws of physics and geometry dictate a difference between the altitudes of the two screws which you sink into the (neighboring) studs.  This app solves the nonlinear equation for that altitude difference.",

        'instructions' => "type <tt>/O/S/W/L/H</tt>, in which each of the five letters represents a positive number as defined below.
        <ul>

        <li> <I>O</I>: desired <b>offset</b> of the middle of the artwork, as measured horizontally from one of the studs</li>

        <li> <I>S</I>: <b>stud</b>-spacing, which is 16\" (but sometimes 24\") for the US and 600 mm for some of Europe.</li>

        <li> <I>W</I>: <b>width</b> of the art, as defined by the distance between the attachment points for each end of the wire (ie <I>not</I> the somewhat larger horizontal distance between the art's left and right edges)</li>

        <li><I>L</I>: total <b>length</b> of the wire running between the two points defined in the previous bullet</li>

        <li> <I>H</I>: <b>height</b> of the top (approximately third) of the artwork, as defined by the distance between the art's top edge and the horizontal line running between the two points described in the earlier bullet (ie <I>not</I> the substantially larger vertical distance between the art's top and bottom edges)</li>

        </ul>

        <b>Notes:</b>
        <ul>
            <li>
                These instructions do not restrict you to any particular set of units (eg inches or millimeters); you simply need to use the same set for all of your numbers.
            </li>
            <li>
                The artwork's weight is shared by the two screws, but this sharing is unequal.  The greater amount of weight is born by the screw that is (laterally) closer to the art's center of gravity.  This app also returns more quantitative information about these forces and the tension in the wire, thereby providing guidance about mounting-hardware needs.
            </li>
            <li>
                Your inputs must satisfy these four constraints:
                <ul>

                    <li>  <I>O</I> &ne; 0 (Otherwise, the artwork can be supported by a single screw in a single stud, making this app unnecessary. Going forward, let's assume that <I>O</I> > 0.) </li>

                    <li> <I>W</I> / 2 &gt; <I>O</I>, ensuring that the artwork's left end overlaps with the left stud. </li>

                    <li> <I>W</I> / 2 &gt; <I>S</I> - <I>O</I>, ensuring that the artwork's right end overlaps with the right stud. </li>

                    <li> <I>L</I> > <I>W</I>, ensuring that the wire suffices to connect the artwork's attachment points. </li>

                </ul>
                In fact the calculation may even fail if you <I>almost</I> violate any of these constraints.
        </ul>",

        'examples' => "<ul>
            <li>
                <button class='web'>Click here</button> to see the relationship between your inputs, the browser's url, and the results ...
            </li>
            <li>
                <button class='mobile'>... or here (WIP)</button> for a mobile-friendly version.
            </li>
        </ul>
        <script>
            const buttons = Array.from(document.getElementsByTagName('button'));
            base = 'https://utilities-3db59a13e37b.herokuapp.com/artHanger/';
            buttons.forEach(button => {
                const url = base + button.getAttribute('class') + '/4/16/28/31/5';
                button.addEventListener(
                    'click',
                    () => window.location.href = url,
                );
            });
        </script>
        ",
    ];
}
