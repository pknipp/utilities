<?php

function makeSignificanceFormatterUtility($name) {
    return [
        'name' => $name,
        'pretty' => 'Significance Formatter',
        'description' => 'This expresses a specified number with a specified number of <a href="https://en.wikipedia.org/wiki/Significant_figures" target="_blank">significant figures</a> (aka sigfigs), using metric prefixes as necessary.',
        'background' => 'The number of significant figures (aka "sigfigs") in the value of a quantity reflects the accuracy with which it is known and/or the extent to which we <i>care</i> about its accuracy. Also, having fewer sigfigs enables more efficient use of real estate on a webpage.  Roughly speaking, the number of sigfigs equals the number of nonzero digits.  See <a href="https://en.wikipedia.org/wiki/Significant_figures" target="_blank">Wikipedia</a> for a more precise definition.',
        'instructions' => "type <tt>/number/digits</tt>, where <tt>number</tt> is the particular quantity's value, and <tt>digits</tt> is the number of sigfigs with which you want this value expressed.",
        'examples' => '
            <div class="text-center">
                <table>
                    <thead>
                        <tr>
                            <th scope="col" rowspan="2">Input</th>
                            <th scope="col" colspan="2">Outputs</th>
                        </tr>
                        <tr>
                            <th scope="col">number</th>
                            <th scope="col">prefix</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <tt>/1234/3</tt>
                            </td>
                            <td>
                                <tt>1.23</tt>
                            </td>
                            <td>
                                <tt>k</tt>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <tt>/99.7/2</tt>
                            </td>
                            <td>
                                100
                            </td>
                            <td>
                                (nothing)
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ',
    ];
}
