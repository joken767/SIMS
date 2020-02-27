
<div class="col-sm-3 col-md-2 sidebar">
@if (Auth::user ()->id == 1)
          <ul class="nav nav-sidebar" id="MainMenu">
            <li><a href="#items_nav" data-toggle="collapse" data-parent="#MainMenu"><h4>Items <span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="items_nav">
                    <li><a href="/create_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Create Items</a></li>
                    <li><a href="/receive_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Receive Items</a></li>
                    <li><a href="/issue_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Issue Items</a></li>
                    <li><a href="/trace_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Trace Item Transactions</a></li>
                    <li><a href="/list_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp List of Items</a></li>
                </ul>
            <li><a href="#documents_nav" data-toggle="collapse" data-parent="#MainMenu"><h4>Documents <span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="documents_nav">
                    <li><a href="/carried_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Inventory of Items Carried on Stock </a></li>
                    <li><a href="/report_issued_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Inventory of Items Issued </a></li>
                </ul> 
                <li><a href="#suppliers_nav" data-toggle="collapse" data-parent="#MainMenu"><h4>Suppliers <span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="suppliers_nav">
                    <li><a href="/create_supplier">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Add Supplier</a></li>
                    <li><a href="supplier">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp List of Suppliers</a></li>
                </ul>
                <li><a href="#offices_nav" data-toggle="collapse" data-parent="#MainMenu"><h4>Offices <span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="offices_nav">
                    <li><a href="/create_location">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Add Office</a></li>
                    <li><a href="/register">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Add Office Account</a></li>
                    <li><a href="/list_location">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp List of Offices</a></li>
                </ul>
          </ul>
    @else
        <ul class="nav nav-sidebar" id="MainMenu_ppmp">
            <li><a href="#ppmp_requests" data-toggle="collapse" data-parent="#MainMenu_ppmp"><h4>PPMP Requests <span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="ppmp_requests">
                    <li><a href="/create_ppmp">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Submit PPMP Request </a></li>
                    <li><a href="/current_ppmp">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Current PPMP Request </a></li>
                    <li><a href="/past_ppmp">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Past PPMP Requests </a></li>
                </ul>
            <li><a href="#documents_gen_nav" data-toggle="collapse" data-parent="#MainMenu_ppmp"><h4>Document Generation<span class="caret"></span></h4></a></li>
                <ul class="nav nav-sidebar collapse" id="documents_gen_nav">
                    <li><a href="/issue_stock">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Generate RIS </a></li>
                    <li><a href="/print_ris">&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Print RIS </a></li>
                </ul>
        </ul>
    @endif
        </div>
