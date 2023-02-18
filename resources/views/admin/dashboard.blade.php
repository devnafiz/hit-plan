@extends('admin.layouts.master')

@section('title', 'Dashboard')

@section('content-header')
<!--<div class="row" style="display: inline-block;">-->
<!--  <div class=" top_tiles" style="margin: 10px 0;">-->
<!--    <div class="col-md-3 col-sm-3  tile">-->
<!--      <span>Today Order</span>-->
<!--      <h2>231,809</h2>-->
<!--      <span class="sparkline_one" style="height: 160px;"><canvas width="478" height="125" style="display: inline-block; width: 478px; height: 125px; vertical-align: top;"></canvas></span>-->
<!--    </div>-->
<!--    <div class="col-md-3 col-sm-3  tile">-->
<!--      <span>This Week Order</span>-->
<!--      <h2>$ 231,809</h2>-->
<!--      <span class="sparkline_one" style="height: 160px;"><canvas width="478" height="125" style="display: inline-block; width: 478px; height: 125px; vertical-align: top;"></canvas></span>-->
<!--    </div>-->
<!--    <div class="col-md-3 col-sm-3  tile">-->
<!--      <span>This Month Order</span>-->
<!--      <h2>231,809</h2>-->
<!--      <span class="sparkline_one" style="height: 160px;"><canvas width="478" height="125" style="display: inline-block; width: 478px; height: 125px; vertical-align: top;"></canvas></span>-->
<!--    </div>-->
<!--    <div class="col-md-3 col-sm-3  tile">-->
<!--      <span>This Year Order</span>-->
<!--      <h2>231,809</h2>-->
<!--      <span class="sparkline_one" style="height: 160px;"><canvas width="478" height="125" style="display: inline-block; width: 478px; height: 125px; vertical-align: top;"></canvas></span>-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->

<div class="row">
  <div class="col-md-12 col-sm-12 ">
    <div class="dashboard_graph x_panel">
      <div class="x_title">
        <div class="col-md-6">
          <h3>Network Activities <small>Graph title sub-title</small></h3>
        </div>
        <div class="col-md-6">
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            <span>February 14, 2020 - March 14, 2020</span> <b class="caret"></b>
          </div>
        </div>
      </div>
      <div class="x_content">
        <div class="demo-container" style="height:250px">
          <div id="chart_plot_03" class="demo-placeholder" style="padding: 0px; position: relative;"><canvas class="flot-base" width="1051" height="280" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1051px; height: 280px;"></canvas>
            <div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
              <div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 15px; text-align: center;">0</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 143px; text-align: center;">2</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 271px; text-align: center;">4</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 399px; text-align: center;">6</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 528px; text-align: center;">8</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 653px; text-align: center;">10</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 781px; text-align: center;">12</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 909px; text-align: center;">14</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; max-width: 116px; top: 264px; left: 1037px; text-align: center;">16</div>
              </div>
              <div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 252px; left: 7px; text-align: right;">0</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 220px; left: 7px; text-align: right;">5</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 189px; left: 1px; text-align: right;">10</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 157px; left: 1px; text-align: right;">15</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 126px; left: 1px; text-align: right;">20</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 95px; left: 1px; text-align: right;">25</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 63px; left: 1px; text-align: right;">30</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 32px; left: 1px; text-align: right;">35</div>
                <div class="flot-tick-label tickLabel" style="position: absolute; top: 1px; left: 1px; text-align: right;">40</div>
              </div>
            </div><canvas class="flot-overlay" width="1051" height="280" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 1051px; height: 280px;"></canvas>
            <div class="legend">
              <div style="position: absolute; width: 82px; height: 17px; top: 13px; right: 13px; background-color: rgb(255, 255, 255); opacity: 0.85;"> </div>
              <table style="position:absolute;top:13px;right:13px;;font-size:smaller;color:#545454">
                <tbody>
                  <tr>
                    <td class="legendColorBox">
                      <div style="border:1px solid #ccc;padding:1px">
                        <div style="width:4px;height:0;border:5px solid rgb(38,185,154);overflow:hidden"></div>
                      </div>
                    </td>
                    <td class="legendLabel">Registrations</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection