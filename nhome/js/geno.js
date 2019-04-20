    function init() {
      //if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
      var $ = go.GraphObject.make;
      myDiagram =
        $(go.Diagram, "myDiagram",
          { initialAutoScale: go.Diagram.Uniform,
            initialContentAlignment: go.Spot.Center });

      function attrFill(a) {
        switch (a) {
          case "A": return "green";
          case "B": return "orange";
          case "C": return "red";
          case "D": return "cyan";
          case "E": return "gold";
          case "F": return "pink";
          case "G": return "blue";
          case "H": return "brown";
          case "I": return "purple";
          case "J": return "chartreuse";
          case "K": return "lightgray";
          case "L": return "magenta";
          default: return "transparent";
        }
      }

      var tlpt = new go.Point(1, 1);
      var trpt = new go.Point(20, 1);
      var brpt = new go.Point(20, 20);
      var blpt = new go.Point(1, 20);
      function malePosition(a) {
        switch (a) {
          case "A": return tlpt;
          case "B": return tlpt;
          case "C": return tlpt;
          case "D": return trpt;
          case "E": return trpt;
          case "F": return trpt;
          case "G": return brpt;
          case "H": return brpt;
          case "I": return brpt;
          case "J": return blpt;
          case "K": return blpt;
          case "L": return blpt;
          default: return tlpt;
        }
      }

      var tlarc = go.Geometry.parse("M20 20 B 180 90 20 20 19 19 z", true);
      var trarc = go.Geometry.parse("M20 20 B 270 90 20 20 19 19 z", true);
      var brarc = go.Geometry.parse("M20 20 B 0 90 20 20 19 19 z", true);
      var blarc = go.Geometry.parse("M20 20 B 90 90 20 20 19 19 z", true);
      function femaleGeometry(a) {
        switch (a) {
          case "A": return tlarc;
          case "B": return tlarc;
          case "C": return tlarc;
          case "D": return trarc;
          case "E": return trarc;
          case "F": return trarc;
          case "G": return brarc;
          case "H": return brarc;
          case "I": return brarc;
          case "J": return blarc;
          case "K": return blarc;
          case "L": return blarc;
          default: return tlarc;
        }
      }

      // two different node templates, one for each sex,
      // named by the category value in the node data object
	  
	  var pathstring = "M 40 0 0 40 L 0 0 40 40";
	  var pathstringC = "M 24 6 L 6 24 X M 6 6 24 24";
	  var pathstringC2 = "M 40 0 L 0 40 X M 0 0 40 40";
	  
      myDiagram.nodeTemplateMap.add("M",  // male
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Rectangle",
              { width: 40, height: 40,
                strokeWidth: 2, fill: "transparent", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape, "Rectangle",
                      { width: 19, height: 19, stroke: null, strokeWidth: 0 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("position", "", malePosition))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
		myDiagram.nodeTemplateMap.add("SM",  // male - subject
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Rectangle",
              { width: 40, height: 40,
                strokeWidth: 2, fill: "black", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape, "Rectangle",
                      { width: 19, height: 19, stroke: null, strokeWidth: 0 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("position", "", malePosition))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
      myDiagram.nodeTemplateMap.add("F",  // female
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Ellipse",
              { width: 40, height: 40,
                strokeWidth: 2, fill: "transparent", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape,
                      { stroke: null, strokeWidth: 0 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("geometry", "", femaleGeometry))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
		myDiagram.nodeTemplateMap.add("SF",  // female - subject
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Ellipse",
              { width: 40, height: 40,
                strokeWidth: 2, fill: "black", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape,
                      { stroke: null, strokeWidth: 0 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("geometry", "", femaleGeometry))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
		var W_geometry = go.Geometry.parse("M 0,0 L 0,50 50,0 50,50 0,0 50,0 50,50 0,50", false);
		myDiagram.nodeTemplateMap.add("DM",  // male - died
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape,
              { geometry: W_geometry, width: 40, height: 40,
                strokeWidth: 2, fill: "transparent", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape,
                      { geometry: W_geometry, width: 19, height: 19, stroke: null, strokeWidth: 2 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("position", "", malePosition))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
		var W_geometryF = go.Geometry.parse("M 8,8 L 58,58 M 8,58 L 58,8", false);
		myDiagram.nodeTemplateMap.add("DF",  // female - died
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Ellipse",
              { width: 40, height: 40,
                strokeWidth: 2, fill: "transparent", portId: "" }),
			$(go.Shape, "Ellipse",
              { geometry: W_geometryF, width: 32, height: 32,
                strokeWidth: 2, fill: "transparent", portId: "" }),
            $(go.Panel,
              { itemTemplate:
                  $(go.Panel,
                    $(go.Shape,
                      { stroke: null, strokeWidth: 0 },
                      new go.Binding("fill", "", attrFill),
                      new go.Binding("geometry", "", femaleGeometry))
                  ),
                margin: 1
              },
              new go.Binding("itemArray", "a")
            )
          ),
          $(go.TextBlock,
            new go.Binding("text", "n"))
        ));
		
		myDiagram.nodeTemplateMap.add("FNS",  // female - died
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Ellipse",
              { width: 0, height: 0,
                strokeWidth: 0, fill: "transparent", portId: "" })
          )
        ));
		
		myDiagram.nodeTemplateMap.add("MNS",  // female - died
        $(go.Node, "Vertical",
          $(go.Panel,
            $(go.Shape, "Ellipse",
              { width: 0, height: 0,
                strokeWidth: 0, fill: "transparent", portId: "" })
          )
        ));

      // the representation of each label node -- nothing
      myDiagram.nodeTemplateMap.add("LinkLabel",
        $(go.Node, { selectable: false, width: 1, height: 1 })
	  );

      myDiagram.linkTemplate =  // the default link template
        $(go.Link,
          { routing: go.Link.Orthogonal, selectable: false, curviness: 10,
            fromSpot: go.Spot.Bottom, toSpot: go.Spot.Top },
          $(go.Shape, { strokeWidth: 2 })
        );

      myDiagram.linkTemplateMap.add("M",  // for marriages
        $(go.Link, { selectable: false },
          $(go.Shape, { strokeWidth: 2, stroke: "black" })
      ));
	  
	  myDiagram.linkTemplateMap.add("N",  // for not show
        $(go.Link, { selectable: false },
          $(go.Shape, { strokeWidth: 2, stroke: "white" })
      ));

      myDiagram.layout =
        $(GenogramLayout, { angle: 90, layerSpacing: 30 });

      // n: name, s: sex, m: mother, f: father, ux: wife, vir: husband, a: attributes/markers
/*      setupDiagram(myDiagram, [
			{ key : 4, n : "bro 1", s: "M", f : 2, m : 3 },  
			{ key : 5, n : "sis 1", s: "F", f : 2, m : 3 },  
			{ key : 0, n : "pat", s : "M", f : 2, m : 3, ux : 1 },  
			{ key : 1, n : "wife", s: "F", vir : 0 },
			{ key : 2, n : "father", s: "M", f: 17, m : 18, ux : 3 },
			{ key : 3, n : "mother", s: "F", vir : 2 },
			{ key : 6, n : "sis 2", s: "F", f : 2, m : 3 },  
			{ key : 7, n : "bro 2", s: "M", f : 2, m : 3 },  
			{ key : 8, n : "son", s: "M", f : 0, m : 1, ux : 19 },  
			{ key : 9, n : "daughter", s: "F", f : 0, m : 1, vir : 10 },
			{ key : 10, n : "son-in-law", s: "M", ux : 9 },
			{ key : 11, n : "grandson", s: "M", f : 8, m : 19 },
			{ key : 12, n : "granddaughter", s: "F", f : 8, m : 19 },
			{ key : 13, n : "maid", s: "F" },
			{ key : 14, n : "friend", s: "F" },
			{ key : 15, n : "uncle", s : "M", f: 17, m : 18, ux : 16},
			{ key : 16, n : "aunt", s : "F", vir : 15},
			{ key : 17, n : "grandpa", s : "M", ux : 18},
			{ key : 18, n : "grandmom", s : "F", vir : 17},
			{ key : 19, n : "daughter-in-law", s : "F", vir : 8},
        ]);
*/    }


    // create and initialize the Diagram.model given an array of node data representing people
    function setupDiagram(diagram, array) {
      diagram.model =
        go.GraphObject.make(go.GraphLinksModel,
          { // declare support for link label nodes
            nodeIsLinkLabelProperty: "isLinkLabel",
            linkLabelKeysProperty: "labelKeys",
            // this property determines which template is used
            nodeCategoryProperty: "s",
            // create all of the nodes for people
            nodeDataArray: array
          });
      setupMarriages(diagram);
      setupParents(diagram);
    }

    function findMarriage(diagram, a, b) {
      var nodeA = diagram.findNodeForKey(a);
      var nodeB = diagram.findNodeForKey(b);
      if (nodeA !== null && nodeB !== null) {
        var it = nodeA.findLinksBetween(nodeB);  // in either direction
        while (it.next()) {
          var link = it.value;
          // Link.data.category === "M" means it's a marriage relationship
          if (link.data !== null && link.data.category === "M") return link;
        }
      }
      return null;
    }

    // now process the node data to determine marriages
    function setupMarriages(diagram) {
      var model = diagram.model;
      var nodeDataArray = model.nodeDataArray;
	  var lineModel = "M";
	  for (var i2 = 0; i2 < nodeDataArray.length; i2++) {
		  var data2 = nodeDataArray[i2];
		  if (data2.s==="MNS" || data2.s==="FNS") {
			  lineModel="M";
		  }
	  }
      for (var i = 0; i < nodeDataArray.length; i++) {
        var data = nodeDataArray[i];
        var key = data.key;
        var uxs = data.ux;
        if (uxs !== undefined) {
          if (typeof uxs === "number") uxs = [ uxs ];
          for (var j = 0; j < uxs.length; j++) {
			var wife = uxs[j];
			if (key === wife) {
			  // or warn no reflexive marriages
			  continue;
			}
			var link = findMarriage(diagram, key, wife);
			if (link === null) {
			  // add a label node for the marriage link
			  var mlab = { isLinkLabel: true };
			  model.addNodeData(mlab);
			  // add the marriage link itself, also referring to the label node
			  var mdata = { from: key, to: wife, labelKeys: [mlab.key], category: lineModel };  
			  model.addLinkData(mdata);
			}
          }
        }
        var virs = data.vir;
        if (virs !== undefined) {
          if (typeof virs === "number") virs = [ virs ];
          for (var j = 0; j < virs.length; j++) {
			var husband = virs[j];
			if (key === husband) {
			  // or warn no reflexive marriages
			  continue;
			}
			var link = findMarriage(diagram, key, husband);
			if (link === null) {
			  // add a label node for the marriage link
			  var mlab = { isLinkLabel: true };
			  model.addNodeData(mlab);
			  // add the marriage link itself, also referring to the label node
			  var mdata = { from: key, to: husband, labelKeys: [mlab.key], category: lineModel };
			  model.addLinkData(mdata);
			}
          }
        }
      }
    }

    // process parent-child relationships once all marriages are known
    function setupParents(diagram) {
      var model = diagram.model;
      var nodeDataArray = model.nodeDataArray;
      for (var i = 0; i < nodeDataArray.length; i++) {
        var data = nodeDataArray[i];
        var key = data.key;
        var mother = data.m;
        var father = data.f;
        if (mother !== undefined && father !== undefined) {
          var link = findMarriage(diagram, mother, father);
          if (link === null) {
            // or warn no known mother or no known father or no known marriage between them
            if (window.console) window.console.log("unknown marriage: " + mother + " & " + father);
            continue;
          }
          var mdata = link.data;
          var mlabkey = mdata.labelKeys[0];
          var cdata = { from: mlabkey, to: key };
          myDiagram.model.addLinkData(cdata);
        }
      }
    }


    function GenogramLayout() {
      go.TreeLayout.call(this);
    }
    go.Diagram.inherit(GenogramLayout, go.TreeLayout);

    GenogramLayout.prototype.makeNetwork = function(coll) {
      // generate LayoutEdges for each parent-child Link
      var net = this.createNetwork();
      if (coll instanceof go.Diagram) {
        this.add(net, coll.nodes, true);
        this.add(net, coll.links, true);
      } else if (coll instanceof go.Group) {
        this.add(net, coll.memberParts, false);
      } else if (coll.iterator) {
        this.add(net, coll.iterator, false);
      }
      return net;
    };

    GenogramLayout.prototype.add = function(net, coll, nonmemberonly) {
      // consider all Nodes in the given collection
      var it = coll.iterator;
      while (it.next()) {
        var node = it.value;
        if (!(node instanceof go.Node)) continue;
        if (!node.isLayoutPositioned || !node.isVisible()) continue;
        if (nonmemberonly && node.containingGroup !== null) continue;
        // if it's an unmarried Node, or if it's a Link Label Node, create a LayoutVertex for it
        if (node.isLinkLabel) {
          // get marriage Link
          var link = node.labeledLink;
          var spouseA = link.fromNode;
          var spouseB = link.toNode;
          // create vertex representing both husband and wife
          var vertex = net.addNode(node);
          // now define the vertex size to be big enough to hold both spouses
          vertex.width = spouseA.actualBounds.width + 30 + spouseB.actualBounds.width;
          vertex.height = Math.max(spouseA.actualBounds.height, spouseB.actualBounds.height);
          vertex.focus = new go.Point(spouseA.actualBounds.width + 30/2, vertex.height/2);
        } else {
          var anymarriage = false;
          var mit = node.linksConnected;
          while (mit.next()) {
            var link = mit.value;
            if (link.isLabeledLink) {  // assume a marriage Link has a label Node
              anymarriage = true;
              break;
            }
          }
          if (!anymarriage) {
            var vertex = net.addNode(node);
          }
        }
      }
      // now do all Links
      it.reset();
      while (it.next()) {
        var link = it.value;
        if (!(link instanceof go.Link)) continue;
        if (!link.isLayoutPositioned || !link.isVisible()) continue;
        if (nonmemberonly && link.containingGroup !== null) continue;
        // if it's a parent-child link, add a LayoutEdge for it
        if (!link.isLabeledLink) {
          var parent = net.findVertex(link.fromNode);  // should be a label node
          var child = net.findVertex(link.toNode);
          if (child !== null) {
            net.linkVertexes(parent, child, link);
          } else {  // to a married person
            var mit = link.toNode.linksConnected;
            while (mit.next()) {
              var l = mit.value;
              if (l.data.category === "M") {
                var lit = l.labelNodes;
                if (lit.next()) {
                  var mlab = lit.value;
                  var mlabvert = net.findVertex(mlab);
                  if (mlabvert !== null) {
                    net.linkVertexes(parent, mlabvert, link);
                  }
                }
              }
            }
          }
        }
      }
    };

    GenogramLayout.prototype.commitNodes = function() {
      // position the spouses of each marriage vertex
      var it = this.network.vertexes.iterator;
      while (it.next()) {
        var v = it.value;
        if (v.node.data.isLinkLabel) {
          var labnode = v.node;
          var lablink = labnode.labeledLink;
          var spouseA = lablink.fromNode;
          var spouseB = lablink.toNode;
          spouseA.position = new go.Point(v.x, v.y);
          spouseB.position = new go.Point(v.x + spouseA.actualBounds.width + 30, v.y);
        } else {
          v.node.position = new go.Point(v.x, v.y);
        }
      }
    };

    // end GenogramLayout class