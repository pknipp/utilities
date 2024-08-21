<?php

function makeGrapher($name) {
    return [
        'name' => $name,
        'pretty' => 'Grapher',
        'description' => 'This renders the svg for a simple scatter-plot.',
        'background' => 'The main consideration here is the design for each axis.  Each axis should be large enough to contain all of the points, small enough to optimize the page, and the tickmarks should be round numbers.',
        'instructions' => "type <tt>/width/xLabel/showZeroX/height/yLabel/showZeroY/xys</tt>, where <tt>width</tt> and <tt>height</tt> are the graph's dimensions in px, <tt>xLabel</tt> and <tt>yLabel</tt> are self-explanatory, the <tt>showZero</tt> variables are booleans that control whether the graph always includes zero on the particular axis regardless of the values of the points, and <tt>xys</tt> is an array of coordinates. You may express a true boolean by either <tt>true</tt>, <tt>TRUE</tt>, <tt>True</tt>, or <tt>T</tt>, and likewise for false.  <tt>xys</tt> is a comma-separated list of points surrounded by brackets.  Each point is designated by a comma-separated pair of floats surrounded by parentheses.  Use of whitespace is allow for both labels and data points, but its use is discouraged for the latter.  Json is only returned in the case of errors.",
        'examples' => "
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
  <nav class=\"navbar navbar-default navbar-static-top navbar-inverse\">
  <div class=\"container\">
    <ul class=\"nav navbar-nav\">
      <li class=\"active\">
        <a href=\"/\"><span class=\"glyphicon glyphicon-home\"></span> Home</a>
      </li>
    </ul>
  </div>
</nav>

  <svg
    height=780
    width=1550
>
    <g
        transform=\"translate(100, 10)\"
    >
        <rect
            height=700
            width=1400
            fill=\"transparent\"
            stroke=\"black\"
        />
        <g
            transform=\"translate(0, 700)\"
        >
            <g>
                                    <g
                      transform=\"translate(0, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-8</text>
                    </g>
                                    <g
                      transform=\"translate(116.66666666667, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-7</text>
                    </g>
                                    <g
                      transform=\"translate(233.33333333333, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-6</text>
                    </g>
                                    <g
                      transform=\"translate(350, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-5</text>
                    </g>
                                    <g
                      transform=\"translate(466.66666666667, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-4</text>
                    </g>
                                    <g
                      transform=\"translate(583.33333333333, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-3</text>
                    </g>
                                    <g
                      transform=\"translate(700, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-2</text>
                    </g>
                                    <g
                      transform=\"translate(816.66666666667, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">-1</text>
                    </g>
                                    <g
                      transform=\"translate(933.33333333333, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">0</text>
                    </g>
                                    <g
                      transform=\"translate(1050, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">1</text>
                    </g>
                                    <g
                      transform=\"translate(1166.6666666667, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">2</text>
                    </g>
                                    <g
                      transform=\"translate(1283.3333333333, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">3</text>
                    </g>
                                    <g
                      transform=\"translate(1400, 0)\"
                    >
                        <line y2=\"10\" stroke=\"black\" />
                        <text y=\"25\" text-anchor=\"middle\" dy=\"0.32em\">4</text>
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
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">-4</text>
                    </g>
                                    <g
                      transform=\"translate(0, -87.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">-2</text>
                    </g>
                                    <g
                      transform=\"translate(0, -175)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">0</text>
                    </g>
                                    <g
                      transform=\"translate(0, -262.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">2</text>
                    </g>
                                    <g
                      transform=\"translate(0, -350)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">4</text>
                    </g>
                                    <g
                      transform=\"translate(0, -437.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">6</text>
                    </g>
                                    <g
                      transform=\"translate(0, -525)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">8</text>
                    </g>
                                    <g
                      transform=\"translate(0, -612.5)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">10</text>
                    </g>
                                    <g
                      transform=\"translate(0, -700)\"
                    >
                        <line x2=\"-10\" stroke=\"black\" />
                        <text x=\"-25\" text-anchor=\"middle\" dy=\"0.32em\">12</text>
                    </g>
                            </g>
            <g
                transform=\"translate(-55, -350) rotate(-90)\"
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
                        cx=1178.3333333333
                        cy=-35
                        r=3.5
                        fill=\"transparent\"
                        stroke=\"black\"
                    />
                                    <circle
                        cx=1306.6666666667
                        cy=-406.875
                        r=3.5
                        fill=\"transparent\"
                        stroke=\"black\"
                    />
                                    <circle
                        cx=70
                        cy=-660.625
                        r=3.5
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
