/*
 Highcharts JS v8.0.1 (2020-03-02)

 (c) 2009-2019 Sebastian Bochan, Rafal Sebestjanski

 License: www.highcharts.com/license
*/
(function(b){"object"===typeof module&&module.exports?(b["default"]=b,module.exports=b):"function"===typeof define&&define.amd?define("highcharts/modules/dumbbell",["highcharts"],function(c){b(c);b.Highcharts=c;return b}):b("undefined"!==typeof Highcharts?Highcharts:void 0)})(function(b){function c(b,l,f,c){b.hasOwnProperty(l)||(b[l]=c.apply(null,f))}b=b?b._modules:{};c(b,"modules/dumbbell.src.js",[b["parts/Globals.js"],b["parts/Utilities.js"]],function(b,c){c=c.seriesType;var f=b.pick,m=b.seriesTypes,
l=b.Series.prototype,n=m.arearange.prototype,r=m.column.prototype,q=n.pointClass.prototype;c("dumbbell","arearange",{trackByArea:!1,fillColor:"none",lineWidth:0,pointRange:1,connectorWidth:1,stickyTracking:!1,groupPadding:.2,pointPadding:.1,lowColor:"#333333",states:{hover:{lineWidthPlus:0,connectorWidthPlus:1,halo:!1}}},{trackerGroups:["group","markerGroup","dataLabelsGroup"],drawTracker:b.TrackerMixin.drawTrackerPoint,drawGraph:b.noop,crispConnector:function(a,b){a[1]===a[4]&&(a[1]=a[4]=Math.floor(a[1])+
b%2/2);a[2]===a[5]&&(a[2]=a[5]=Math.floor(a[2])+b%2/2);return a},crispCol:r.crispCol,getConnectorAttribs:function(a){var t=this.chart,e=a.options,h=this.options,d=this.xAxis,g=this.yAxis,c=f(e.connectorWidth,h.connectorWidth),l=f(e.connectorColor,h.connectorColor,e.color,a.zone?a.zone.color:void 0,a.color),n=f(h.states&&h.states.hover&&h.states.hover.connectorWidthPlus,1),m=f(e.dashStyle,h.dashStyle),p=f(a.plotLow,a.plotY),k=g.toPixels(h.threshold||0,!0);k=f(a.plotHigh,t.inverted?g.len-k:k);a.state&&
(c+=n);0>p?p=0:p>=g.len&&(p=g.len);0>k?k=0:k>=g.len&&(k=g.len);if(0>a.plotX||a.plotX>d.len)c=0;a.upperGraphic&&(d={y:a.y,zone:a.zone},a.y=a.high,a.zone=a.zone?a.getZone():void 0,l=f(e.connectorColor,h.connectorColor,e.color,a.zone?a.zone.color:void 0,a.color),b.extend(a,d));a={d:this.crispConnector(["M",a.plotX,p,"L",a.plotX,k],c)};t.styledMode||(a.stroke=l,a["stroke-width"]=c,m&&(a.dashstyle=m));return a},drawConnector:function(a){var b=f(this.options.animationLimit,250);b=a.connector&&this.chart.pointCount<
b?"animate":"attr";a.connector||(a.connector=this.chart.renderer.path().addClass("highcharts-lollipop-stem").attr({zIndex:-1}).add(this.markerGroup));a.connector[b](this.getConnectorAttribs(a))},getColumnMetrics:function(){var a=r.getColumnMetrics.apply(this,arguments);a.offset+=a.width/2;return a},translatePoint:n.translate,setShapeArgs:m.columnrange.prototype.translate,translate:function(){this.setShapeArgs.apply(this);this.translatePoint.apply(this,arguments);this.points.forEach(function(a){var b=
a.shapeArgs,e=a.pointWidth;a.plotX=b.x;b.x=a.plotX-e/2;a.tooltipPos=null})},seriesDrawPoints:n.drawPoints,drawPoints:function(){var a=this.chart,b=this.points.length,e=this.lowColor=this.options.lowColor,c=0;for(this.seriesDrawPoints.apply(this,arguments);c<b;){var d=this.points[c];this.drawConnector(d);d.upperGraphic&&(d.upperGraphic.element.point=d,d.upperGraphic.addClass("highcharts-lollipop-high"));d.connector.element.point=d;if(d.lowerGraphic){var g=d.zone&&d.zone.color;g=f(d.options.lowColor,
e,d.options.color,g,d.color,this.color);a.styledMode||d.lowerGraphic.attr({fill:g});d.lowerGraphic.addClass("highcharts-lollipop-low")}c++}},markerAttribs:function(){var a=n.markerAttribs.apply(this,arguments);a.x=Math.floor(a.x);a.y=Math.floor(a.y);return a},pointAttribs:function(a,b){var c=l.pointAttribs.apply(this,arguments);"hover"===b&&delete c.fill;return c}},{destroyElements:q.destroyElements,isValid:q.isValid,pointSetState:q.setState,setState:function(){var a=this.series,c=a.chart,e=a.options.marker,
h=this.options,d=f(h.lowColor,a.options.lowColor,h.color,this.zone&&this.zone.color,this.color,a.color),g="attr";this.pointSetState.apply(this,arguments);this.state||(g="animate",this.lowerGraphic&&!c.styledMode&&(this.lowerGraphic.attr({fill:d}),this.upperGraphic&&(c={y:this.y,zone:this.zone},this.y=this.high,this.zone=this.zone?this.getZone():void 0,e=f(this.marker?this.marker.fillColor:void 0,e?e.fillColor:void 0,h.color,this.zone?this.zone.color:void 0,this.color),this.upperGraphic.attr({fill:e}),
b.extend(this,c))));this.connector[g](a.getConnectorAttribs(this))}});""});c(b,"masters/modules/dumbbell.src.js",[],function(){})});
//# sourceMappingURL=dumbbell.js.map