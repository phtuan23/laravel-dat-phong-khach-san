<div class="card  mt-3">
                    <div class="card-body check_sale">
                        @if($_booking->sale == 0)
                        <form action="" id="form_sale">
                            <h6><b>Bạn có mã giảm giá không ?</b></h6>
                            <div class="form-group">
                                <label for="">Nhập mã giảm giá của bạn</label>
                                <input type="text" class="form-control" name="code_sale" placeholder="Mã giảm giá">
                                <button class="btn mt-3 w-100" id="code_sale" style="background-color: #dfa974; border-color:#dfa974">Áp dụng</button>
                            </div>
                        </form>
                        @else
                        <div class="text-center"><span class="badge badge-success p-2">Mã giảm giá đã được áp dụng</span></div>
                        @endif
                    </div>
                </div>
                <div class="card " style="margin-top: 38px" id="total_amount">
                    <div class="card-body">
                        <h4>Tổng giá tiền</h4>
                        <br>
                        <table>
                            <tr>
                                <th>Tiền phòng : </th>
                                <td>{{number_format($_booking->total_price)}}đ</td>
                            </tr>
                            <tr>
                                <?php $vat =  $_booking->total_price*(10/100)?>
                                <th>10% VAT :</th>
                                <td><?=number_format($vat);?>đ</td>
                            </tr>
                            <tr>
                                <th>Dịch vụ riêng :</th>
                                <td></td>
                            </tr>
                            @if($_booking->sale!=0)
                            <tr>
                                <th>Giảm giá :</th>
                                <td>{{$_booking->sale*100}} %</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Tổng tiền:</th>
                                <td><?=number_format($_booking->total_price+$vat-($_booking->total_price*$_booking->sale))?>đ</td>
                            </tr>
                            <tr>
                                <th>
                                    <p>(Tổng tiền phải thanh toán)</p>
                                </th>
                            </tr>
                        </table>
                    </div>            
                </div>