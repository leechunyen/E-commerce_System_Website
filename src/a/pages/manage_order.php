<?php require '../../php_framework/function.php';
checkAdminLogin(true,'manage-order');?>
<div class="float-left btn-group" role="group">
    <button onclick="showAll();" type="button" class="btn btn-secondary">All</button>
    <button onclick="showOrder();" type="button" class="btn btn-secondary">Order</button>
    <button onclick="showShippedOut();" type="button" class="btn btn-secondary">ShippedOut</button>
</div>
<label id="lbmode" class="float-left"></label>
<div class="float-right btn-group" role="group">
    <button onclick="reset();" type="button" class="btn btn-secondary">Reset</button>
</div>
<div id="divse" class="float-right input-group mb-3">
    <input id="ipse" type="text" class="form-control" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
        <button onclick="search();" class="btn btn-outline-secondary" type="button" id="button-addon2">Search</button>
    </div>
</div>
<table class="table table-sm table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date Time</th>
            <th>Items Count</th>
            <th>Shipped Out</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="tb_ls">
        <tr>
            <td></td><td></td><td>
                <center><br/><br/>
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading...
                    </button>
                <br/><br/></center>
            </td><td></td><td></td>
        </tr>
    </tbody>
</table>
<div>
    <button onclick="previous();" type="button" class="btnp d-inline btn btn-primary btn-sm">Previous</button>
    <button onclick="next();" type="button" class="btnp d-inline btn btn-primary btn-sm">Next</button>
    <div class="d-inline">
        <label  class="d-inline">Total of Result:&nbsp;<label id="oprt">0</label></label>
        &nbsp;&nbsp;&nbsp;
        <div  class="d-inline">
            <label>Number of rows:&nbsp;
                <select onchange="changeNumOfRow();" id="sel_nor">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="150">150</option>
                    <option value="200">200</option>
                </select>
            </label>
        </div>
    </div>
</div>
<div id="view_modal" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <div class="dp_il_b viewcts">
                        Order ID:&nbsp;<label id="void"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        User ID:&nbsp;<label id="vuid"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Order Date Time:&nbsp;<label id="vodt"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Total Items:&nbsp;<label id="vtit"></label>
                    </div>
                </div>
                <div>
                    <label>Shipping info:</label><br/>
                    <div class="dp_il_b viewcts">
                        Name:&nbsp;<label id="vspn"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Phone:&nbsp;<label id="vspp"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Email:&nbsp;<label id="vspe"></label>
                    </div>
                    <div>
                        <div class="viewcts">
                            Address:&nbsp;<label id="vspa"></label>
                        </div>
                    </div>
                </div>
                <div id="pdtdiv">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody id="pdtls"></tbody>
                    </table>
                </div>
                <div class="float-left botdiv">
                    <label>Payment:</label>
                    <div class="viewcts">
                        Total:&nbsp;<label id="vtot"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Shipping Fee:&nbsp;<label id="vspf"></label>
                    </div>
                    <div class="dp_il_b viewcts">
                        Shipping Method:&nbsp;<label id="vspm"></label>
                    </div>
                    <div class="viewcts">
                        Coupon:&nbsp;<label id="vucp"></label>
                    </div>
                    <div class="viewcts">
                        Paid:&nbsp;<label id="vpad"></label>
                    </div>
                </div>
                <div id="spdiv" class="float-right botdiv">
                    <label>Shipping:</label>
                    <div class="viewcts">
                        Shipped Out:&nbsp;<label id="vspo"></label>
                    </div>
                    
                    <div id="vsptdiv">
                        <div class="viewcts">
                            Date Time:&nbsp;<label id="vspd"></label>
                        </div>
                        <div class="viewcts">
                            Tracking Code:&nbsp;<label id="vspt"></label>
                        </div>
                    </div>
                    <div id="vspsdiv">
                        <button onclick="shipOut(this);" id="btso" type="button" class="btn btn-primary">Shipped Out</button>
                        <div id="vspiptnodiv" class="viewcts vsptdiv hide">
                            <label for="iptno">Tracking Code</label>
                            <input type="email" class="form-control" id="iptno" placeholder="Tracking Code">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                            <div id="ermg_tc" class="invalid-feedback"></div>
                            <div id="btiptcdiv">
                                <button onclick="saveTrackingCode();" type="button" class="dp_il_b btn btn-primary">Save</button>
                                <button onclick="shipOutCancel();" type="button" class="dp_il_b btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="../js/manage_order.js"></script>