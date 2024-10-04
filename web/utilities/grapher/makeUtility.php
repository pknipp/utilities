<?php

function makeGrapher($name) {
    return [
        'name' => $name,
        'pretty' => 'Grapher',
        'description' => 'This renders the svg for a simple scatter-plot.',
        'background' => 'The main consideration here is the design for each axis.  Each axis should be large enough to contain all points, be small enough to optimize the page, and have tickmarks that are round numbers.',
        'instructions' => "type <tt>/width/xLabel/showZeroX/height/yLabel/showZeroY/xys</tt>, where <tt>width</tt> and <tt>height</tt> are the graph's dimensions in px, <tt>xLabel</tt> and <tt>yLabel</tt> are self-explanatory, the <tt>showZero</tt> variables are booleans that control whether the graph always includes zero on the particular axis regardless of the values of the points, and <tt>xys</tt> is an array of coordinates. You may express a true boolean by either <tt>true</tt>, <tt>TRUE</tt>, <tt>True</tt>, or <tt>T</tt>, and likewise for false.  <tt>xys</tt> is a comma-separated list of points surrounded by brackets.  Each point is designated by a comma-separated pair of floats surrounded by parentheses.  Use of whitespace is allowed for both labels and data points, but its use is discouraged for the latter.  Json is only returned in the case of errors.",
        'examples' => "following input yields a three-point graph <tt>/grapher/1400/label (units)/T/450/another label (more units)/F/[(2.1,3.2),(3.2,5.3),(7.4,1.91)]</tt>
        <!DOCTYPE html>
<html>
<head>
  <title>math utilities</title>
<link rel=\"stylesheet\" type=\"text/css\" href=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css\" />
<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js\"></script>
<script type=\"text/javascript\" src=\"//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js\"></script>
<link rel=\"stylesheet\" type=\"text/css\" href=\"/stylesheets/main.css\" />
</head>
<body>
  <svg
    height=530
    width=1550
>
    <g
        transform=\"translate(100, 10)\"
    >
        <rect
            height=450
            width=1400
            fill=\"transparent\"
            stroke=\"black\"
        />
        <g
            transform=\"translate(0, 450)\"
        >
            <g>
                                    <g
                      transform=\"translate(0, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">0</text>
                    </g>
                                    <g
                      transform=\"translate(175, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">1</text>
                    </g>
                                    <g
                      transform=\"translate(350, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">2</text>
                    </g>
                                    <g
                      transform=\"translate(525, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">3</text>
                    </g>
                                    <g
                      transform=\"translate(700, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">4</text>
                    </g>
                                    <g
                      transform=\"translate(875, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">5</text>
                    </g>
                                    <g
                      transform=\"translate(1050, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">6</text>
                    </g>
                                    <g
                      transform=\"translate(1225, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">7</text>
                    </g>
                                    <g
                      transform=\"translate(1400, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">8</text>
                    </g>
                            </g>
            <g
                transform=\"translate(700, 50)\"
            >
                <text
                  text-anchor=\"middle\"
                  dy=\"0.32em\"
                  font-size=\"20\"
                >
                    label (units)
                </text>
            </g>
            <g>
                                    <g
                      transform=\"translate(0, 0)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">1.5</text>
                    </g>
                                    <g
                      transform=\"translate(0, -56.25)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">2</text>
                    </g>
                                    <g
                      transform=\"translate(0, -112.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">2.5</text>
                    </g>
                                    <g
                      transform=\"translate(0, -168.75)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">3</text>
                    </g>
                                    <g
                      transform=\"translate(0, -225)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">3.5</text>
                    </g>
                                    <g
                      transform=\"translate(0, -281.25)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">4</text>
                    </g>
                                    <g
                      transform=\"translate(0, -337.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">4.5</text>
                    </g>
                                    <g
                      transform=\"translate(0, -393.75)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">5</text>
                    </g>
                                    <g
                      transform=\"translate(0, -450)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">5.5</text>
                    </g>
                            </g>
            <g
                transform=\"translate(-55, -225) rotate(-90)\"
            >
                <text
                  text-anchor=\"middle\"
                  dy=\"0.32em\"
                  font-size=\"20\"
                >
                    another label (more units)
                </text>
            </g>
            <g>
                                    <circle
                        cx=367.5
                        cy=-191.25
                        r=2.25
                        fill=\"transparent\"
                        stroke=\"black\"
                    />
                                    <circle
                        cx=560
                        cy=-427.5
                        r=2.25
                        fill=\"transparent\"
                        stroke=\"black\"
                    />
                                    <circle
                        cx=1295
                        cy=-46.125
                        r=2.25
                        fill=\"transparent\"
                        stroke=\"black\"
                    />
                            </g>
        </g>
    </g>
</svg>
</body>
</html>
",
    ];
}
