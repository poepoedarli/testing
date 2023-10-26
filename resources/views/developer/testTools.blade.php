@extends('developer.index')
<script src="{{ asset('js/lib/go.js') }}"></script>

@section('developer-content')
    {{--  <form action="#" method="POST">
        <textarea name="content" id="editor"></textarea>
        <br>
        <div class="col-sm-12 d-md-flex justify-content-md-end mt-4">
            <button type="button" class="btn btn-sm btn-secondary">run
            </button>
        </div>
    </form>

    <script>
        CKEDITOR.replace('editor', {
            language: 'en'
        });
    </script> --}}
    <div style="margin-left: 20px;">
        <button class="btn btn-primary d-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                aria-controls="collapseExample">
            Instruction
        </button>
        {{-- <div class="collapse show " id="collapseExample" style="margin: 20px 20px 20px 0">
            <div class="d-flex justify-content-center">
                Welcome to the Application Development page.
                Here you will be able to take control of all available services to create your own
                customized application
                using our simple and intuitive flowchart UI.

                On the left is the Module Panel, where you will find the diagrammatic representations of existing
                services
                and control logic. Drag and drop into the Workflow Designer space, and hover on one side of the node to
                reveal connection points. Simply click to activate a connector and drag to another node.


                Click Save at the bottom of the page to save your progress, before heading to the Deploy page to
                download
                your application.
            </div>
        </div> --}}
    </div>

    <div class="row" >
        <div class="col col-12" style="position: relative;">
            <div id="instruction" class="mb-0" style="z-index: 99999; position: absolute; width: 95%; background: white; padding: 1rem; font-family:math"> 
                <p>Welcome to the Application Development page. Here you will be able to take control of all available services to create your own customized application using our simple and intuitive flowchart UI.</p>
        
                <p>On the left is the Module Panel, where you will find the diagrammatic representations of existing services and control logic. Drag and drop into the Workflow Designer space, and hover on one side of the node to reveal connection points. Simply click to activate a connector and drag to another node.
                </p>
        
                <p class="mb-0">Click Save at the bottom of the page to save your progress, before heading to the Deploy page to download your application.</p>
            </div>
        </div>
    </div>
    
    
    

    <div class="content m-0 px-0" id="graph-content" >
        <div id="allSampleContent" class="p-2  w-full">
            <div id="sample">
                
                <div style="width: 100%; display: flex; justify-content: space-between">
                    <div id="myPaletteDiv"
                        style="width: 196px; margin-right: 2px; background-color: #ffffff; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto;">
                        
                        <div style="position: absolute; overflow: auto; width: 100px; height: 750px; z-index: 1;">
                            <div style="position: absolute; width: 1px; height: 1px;"></div>
                        </div>
                    </div>
                    <div id="myDiagramDiv"
                        style="flex-grow: 1; height: 750px; background-color: #ffffff; position: relative; -webkit-tap-highlight-color: rgba(255, 255, 255, 0); cursor: auto; border-left: 1px solid #e7e7e7">
                        <div style="position: absolute; overflow: auto; width: 954px; height: 750px; z-index: 1;">
                            <div style="position: absolute; width: 1px; height: 1px;"></div>
                        </div>
                    </div>
                </div>
                
                <button id="SaveButton" onclick="save()" class="mt-3">Save</button>
                
            </div>

            <div class="mt-2">
                <textarea id="diagram-model" style="height: 14rem; width: 100%; display: none">
                    { 
                        "class": "go.GraphLinksModel",
                        "linkFromPortIdProperty": "fromPort",
                        "linkToPortIdProperty": "toPort",
                        "nodeDataArray": [

                        ],
                        "linkDataArray": [

                        ]
                    }
                </textarea>
            </div>
        </div>
    </div>

    <script id="code">
        function init() {
            if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this

            // Since 2.2 you can also author concise templates with method chaining instead of GraphObject.make
            // For details, see https://gojs.net/latest/intro/buildingObjects.html
            const $ = go.GraphObject.make;  // for conciseness in defining templates

            myDiagram =
                new go.Diagram("myDiagramDiv",  // must name or refer to the DIV HTML element
                    {
                        "LinkDrawn": showLinkLabel,  // this DiagramEvent listener is defined below
                        "LinkRelinked": showLinkLabel,
                        "undoManager.isEnabled": true  // enable undo & redo
                    });

            // when the document is modified, add a "*" to the title and enable the "Save" button
            myDiagram.addDiagramListener("Modified", e => {
                var button = document.getElementById("SaveButton");
                if (button) button.disabled = !myDiagram.isModified;
                var idx = document.title.indexOf("*");
                if (myDiagram.isModified) {
                    if (idx < 0) document.title += "*";
                } else {
                    if (idx >= 0) document.title = document.title.slice(0, idx);
                }
            });

            // helper definitions for node templates

            function nodeStyle() {
                return [
                    // The Node.location comes from the "loc" property of the node data,
                    // converted by the Point.parse static method.
                    // If the Node.location is changed, it updates the "loc" property of the node data,
                    // converting back using the Point.stringify static method.
                    new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
                    {
                        // the Node.location is at the center of each node
                        locationSpot: go.Spot.Center
                    }
                ];
            }

            // Define a function for creating a "port" that is normally transparent.
            // The "name" is used as the GraphObject.portId,
            // the "align" is used to determine where to position the port relative to the body of the node,
            // the "spot" is used to control how links connect with the port and whether the port
            // stretches along the side of the node,
            // and the boolean "output" and "input" arguments control whether the user can draw links from or to the port.
            function makePort(name, align, spot, output, input) {
                var horizontal = align.equals(go.Spot.Top) || align.equals(go.Spot.Bottom);
                // the port is basically just a transparent rectangle that stretches along the side of the node,
                // and becomes colored when the mouse passes over it
                return $(go.Shape,
                    {
                        fill: "transparent",  // changed to a color in the mouseEnter event handler
                        strokeWidth: 0,  // no stroke
                        width: horizontal ? NaN : 8,  // if not stretching horizontally, just 8 wide
                        height: !horizontal ? NaN : 8,  // if not stretching vertically, just 8 tall
                        alignment: align,  // align the port on the main Shape
                        stretch: (horizontal ? go.GraphObject.Horizontal : go.GraphObject.Vertical),
                        portId: name,  // declare this object to be a "port"
                        fromSpot: spot,  // declare where links may connect at this port
                        fromLinkable: output,  // declare whether the user may draw links from here
                        toSpot: spot,  // declare where links may connect at this port
                        toLinkable: input,  // declare whether the user may draw links to here
                        cursor: "pointer",  // show a different cursor to indicate potential link point
                        mouseEnter: (e, port) => {  // the PORT argument will be this Shape
                            if (!e.diagram.isReadOnly) port.fill = "rgba(255,0,255,0.5)";
                        },
                        mouseLeave: (e, port) => port.fill = "transparent"
                    });
            }

            function textStyle() {
                return {
                    font: "bold 11pt Lato, Helvetica, Arial, sans-serif",
                    stroke: "#F8F8F8"
                }
            }

            // define the Node templates for regular nodes

            myDiagram.nodeTemplateMap.add("",  // the default category
                $(go.Node, "Table", nodeStyle(),
                    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
                    $(go.Panel, "Auto",
                        $(go.Shape, "Rectangle",
                            { fill: "#282c34", stroke: "#00A9C9", strokeWidth: 3.5 },
                            new go.Binding("figure", "figure")),
                        $(go.TextBlock, textStyle(),
                            {
                                margin: 8,
                                maxSize: new go.Size(160, NaN),
                                wrap: go.TextBlock.WrapFit,
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    ),
                    // four named ports, one on each side:
                    makePort("T", go.Spot.Top, go.Spot.TopSide, false, true),
                    makePort("L", go.Spot.Left, go.Spot.LeftSide, true, true),
                    makePort("R", go.Spot.Right, go.Spot.RightSide, true, true),
                    makePort("B", go.Spot.Bottom, go.Spot.BottomSide, true, false)
                ));

            myDiagram.nodeTemplateMap.add("Conditional",
                $(go.Node, "Table", nodeStyle(),
                    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
                    $(go.Panel, "Auto",
                        $(go.Shape, "Diamond",
                            { fill: "#282c34", stroke: "#00A9C9", strokeWidth: 3.5 },
                            new go.Binding("figure", "figure")),
                        $(go.TextBlock, textStyle(),
                            {
                                margin: 8,
                                maxSize: new go.Size(160, NaN),
                                wrap: go.TextBlock.WrapFit,
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    ),
                    // four named ports, one on each side:
                    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
                    makePort("L", go.Spot.Left, go.Spot.Left, true, true),
                    makePort("R", go.Spot.Right, go.Spot.Right, true, true),
                    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
                ));

            myDiagram.nodeTemplateMap.add("Start",
                $(go.Node, "Table", nodeStyle(),
                    $(go.Panel, "Spot",
                        $(go.Shape, "Circle",
                            { desiredSize: new go.Size(70, 70), fill: "#282c34", stroke: "#09d3ac", strokeWidth: 3.5 }),
                        $(go.TextBlock, "Start", textStyle(),
                            new go.Binding("text"))
                    ),
                    // three named ports, one on each side except the top, all output only:
                    makePort("L", go.Spot.Left, go.Spot.Left, true, false),
                    makePort("R", go.Spot.Right, go.Spot.Right, true, false),
                    makePort("B", go.Spot.Bottom, go.Spot.Bottom, true, false)
                ));

            myDiagram.nodeTemplateMap.add("End",
                $(go.Node, "Table", nodeStyle(),
                    $(go.Panel, "Spot",
                        $(go.Shape, "Circle",
                            { desiredSize: new go.Size(60, 60), fill: "#282c34", stroke: "#DC3C00", strokeWidth: 3.5 }),
                        $(go.TextBlock, "End", textStyle(),
                            new go.Binding("text"))
                    ),
                    // three named ports, one on each side except the bottom, all input only:
                    makePort("T", go.Spot.Top, go.Spot.Top, false, true),
                    makePort("L", go.Spot.Left, go.Spot.Left, false, true),
                    makePort("R", go.Spot.Right, go.Spot.Right, false, true)
                ));

            // taken from https://unpkg.com/gojs@2.3.10/extensions/Figures.js:
            go.Shape.defineFigureGenerator("File", (shape, w, h) => {
                var geo = new go.Geometry();
                var fig = new go.PathFigure(0, 0, true); // starting point
                geo.add(fig);
                fig.add(new go.PathSegment(go.PathSegment.Line, .75 * w, 0));
                fig.add(new go.PathSegment(go.PathSegment.Line, w, .25 * h));
                fig.add(new go.PathSegment(go.PathSegment.Line, w, h));
                fig.add(new go.PathSegment(go.PathSegment.Line, 0, h).close());
                var fig2 = new go.PathFigure(.75 * w, 0, false);
                geo.add(fig2);
                // The Fold
                fig2.add(new go.PathSegment(go.PathSegment.Line, .75 * w, .25 * h));
                fig2.add(new go.PathSegment(go.PathSegment.Line, w, .25 * h));
                geo.spot1 = new go.Spot(0, .25);
                geo.spot2 = go.Spot.BottomRight;
                return geo;
            });

            myDiagram.nodeTemplateMap.add("Comment",
                $(go.Node, "Auto", nodeStyle(),
                    $(go.Shape, "File",
                        { fill: "#282c34", stroke: "#DEE0A3", strokeWidth: 3 }),
                    $(go.TextBlock, textStyle(),
                        {
                            margin: 8,
                            maxSize: new go.Size(200, NaN),
                            wrap: go.TextBlock.WrapFit,
                            textAlign: "center",
                            editable: true
                        },
                        new go.Binding("text").makeTwoWay())
                    // no ports, because no links are allowed to connect with a comment
                ));


            // replace the default Link template in the linkTemplateMap
            myDiagram.linkTemplate =
                $(go.Link,  // the whole link panel
                    {
                        routing: go.Link.AvoidsNodes,
                        curve: go.Link.JumpOver,
                        corner: 5, toShortLength: 4,
                        relinkableFrom: true,
                        relinkableTo: true,
                        reshapable: true,
                        resegmentable: true,
                        // mouse-overs subtly highlight links:
                        mouseEnter: (e, link) => link.findObject("HIGHLIGHT").stroke = "rgba(30,144,255,0.2)",
                        mouseLeave: (e, link) => link.findObject("HIGHLIGHT").stroke = "transparent",
                        selectionAdorned: false
                    },
                    new go.Binding("points").makeTwoWay(),
                    $(go.Shape,  // the highlight shape, normally transparent
                        { isPanelMain: true, strokeWidth: 8, stroke: "transparent", name: "HIGHLIGHT" }),
                    $(go.Shape,  // the link path shape
                        { isPanelMain: true, stroke: "gray", strokeWidth: 2 },
                        new go.Binding("stroke", "isSelected", sel => sel ? "dodgerblue" : "gray").ofObject()),
                    $(go.Shape,  // the arrowhead
                        { toArrow: "standard", strokeWidth: 0, fill: "gray" }),
                    $(go.Panel, "Auto",  // the link label, normally not visible
                        { visible: false, name: "LABEL", segmentIndex: 2, segmentFraction: 0.5 },
                        new go.Binding("visible", "visible").makeTwoWay(),
                        $(go.Shape, "RoundedRectangle",  // the label shape
                            { fill: "#F8F8F8", strokeWidth: 0 }),
                        $(go.TextBlock, "Yes",  // the label
                            {
                                textAlign: "center",
                                font: "10pt helvetica, arial, sans-serif",
                                stroke: "#333333",
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    )
                );

            // Make link labels visible if coming out of a "conditional" node.
            // This listener is called by the "LinkDrawn" and "LinkRelinked" DiagramEvents.
            function showLinkLabel(e) {
                var label = e.subject.findObject("LABEL");
                if (label !== null) label.visible = (e.subject.fromNode.data.category === "Conditional");
            }

            // temporary links used by LinkingTool and RelinkingTool are also orthogonal:
            myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Orthogonal;
            myDiagram.toolManager.relinkingTool.temporaryLink.routing = go.Link.Orthogonal;

            load();  // load an initial diagram from some JSON text

            // initialize the Palette that is on the left side of the page
            myPalette =
                new go.Palette("myPaletteDiv",  // must name or refer to the DIV HTML element
                    {
                        // Instead of the default animation, use a custom fade-down
                        "animationManager.initialAnimationStyle": go.AnimationManager.None,
                        "InitialAnimationStarting": animateFadeDown, // Instead, animate with this function

                        nodeTemplateMap: myDiagram.nodeTemplateMap,  // share the templates used by myDiagram
                        model: new go.GraphLinksModel([  // specify the contents of the Palette
                            { category: "Start", text: "Start" },
                            { category: "Start", text: "Start" },
                            { text: "Dataset Selection" },
                            { text: "Inno-OCR" },
                            { text: "Inno-ADC" },
                            { text: "Result View" },
                            { category: "Conditional", text: "State?" },
                            { category: "End", text: "End" },
                            
                        ])
                    });

            // This is a re-implementation of the default animation, except it fades in from downwards, instead of upwards.
            function animateFadeDown(e) {
                var diagram = e.diagram;
                var animation = new go.Animation();
                animation.isViewportUnconstrained = true; // So Diagram positioning rules let the animation start off-screen
                animation.easing = go.Animation.EaseOutExpo;
                animation.duration = 900;
                // Fade "down", in other words, fade in from above
                animation.add(diagram, 'position', diagram.position.copy().offset(0, 200), diagram.position);
                animation.add(diagram, 'opacity', 0, 1);
                animation.start();
            }

            //window.scrollTo(0, 170)
        } // end init


        // Show the diagram's model in JSON format that the user may edit
        function save() {
            console.log(myDiagram.model.toJson())
            document.getElementById("diagram-model").value = myDiagram.model.toJson();
            myDiagram.isModified = false;
        }
        function load() {
            myDiagram.model = go.Model.fromJson(document.getElementById("diagram-model").value);
        }

        // print the diagram by opening a new window holding SVG images of the diagram contents for each page
        function printDiagram() {
            var svgWindow = window.open();
            if (!svgWindow) return;  // failure to open a new Window
            var printSize = new go.Size(700, 960);
            var bnds = myDiagram.documentBounds;
            var x = bnds.x;
            var y = bnds.y;
            while (y < bnds.bottom) {
                while (x < bnds.right) {
                    var svg = myDiagram.makeSvg({ scale: 1.0, position: new go.Point(x, y), size: printSize });
                    svgWindow.document.body.appendChild(svg);
                    x += printSize.width;
                }
                x = bnds.x;
                y += printSize.height;
            }
            setTimeout(() => svgWindow.print(), 1);
        }
        window.addEventListener('DOMContentLoaded', init);


        function resetPaddingTop(extra = 0){
            let height = $("#instruction").height();
            console.log('height '+height + 'extra '+extra)
            let padding_top = 80 + (height-135) - extra
            console.log('padding_top' + padding_top )
            $("#graph-content").css('padding-top', `${padding_top}px`)
        }


        window.addEventListener('resize', function(event) {
            console.log('resize')
            resetPaddingTop();


        }, true)

        $(document).ready(function() {
            resetPaddingTop();

            $("#menu-sidebar-toggle").click(function(){
                setTimeout(() => {
                    if( window.expanded == 1){
                        resetPaddingTop(10)
                    }
                    else{
                        resetPaddingTop();
                    }
                }, 100);
                
            })
        })

        
    </script>

@endsection