<?php
# PHPlot Demo   
# 2008-01-09 ljb   
# For more information see http://sourceforge.net/projects/phplot/   
 
# Load the PHPlot class library:   
require_once 'phplot/phplot.php';   


# Define the data array: Label, the 3 data sets.   
# Year,  Features, Bugs, Happy Users:   
$data = array();
$total = $_GET['total'] + 1;
for($i = 1; $i < $total ; $i++){
	$data[] = array('版本'. $i . '-非Pass'.$_GET[$i]."个",$_GET[$i]);
}

# Create a PHPlot object which will make a 600x400 pixel image:   
$p = new PHPlot(850, 300);   
 
# Use TrueType fonts:   
$p->SetDefaultTTFont('phplot/simsun.ttc');
 
# Set the main plot title:
$p->SetTitle('版本非PASS测试例数量直方图');   
 
# Select the data array representation and store the data:   
$p->SetDataType('text-data');   
$p->SetDataValues($data);
 
# Select the plot type - bar chart:   
$p->SetPlotType('bars');
 
# Define the data range. PHPlot can do this automatically, but not as well.  
//$p->SetPlotAreaWorld(0, 0, 7, 100);   
 
# Select an overall image background color and another color under the plot:   
$p->SetBackgroundColor('#CCDDED');   
$p->SetDrawPlotAreaBackground(True);   
$p->SetPlotBgColor('#CCDDED');   
 
# Draw lines on all 4 sides of the plot:   
$p->SetPlotBorderType('full');   

# Set a 3 line legend, and position it in the upper left corner:   
$p->SetLegend(array('No Pass'));
$p->SetLegendWorld(0.1, 95);
# Turn data labels on, and all ticks and tick labels off:   
$p->SetXDataLabelPos('plotdown');
$p->SetXTickPos('none');
$p->SetXTickLabelPos('none');   
$p->SetYTickPos('none');   
$p->SetYTickLabelPos('none');   
 
# Generate and output the graph now:   
$p->DrawGraph();
?>