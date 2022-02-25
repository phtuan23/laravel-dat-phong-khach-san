@extends('layout.client')
 @section('content')
 <!-- Contact Section Begin -->
 <section class="contact-section spad">
     <div class="container">
         <div class="row">
             <div class="col-lg-4">
                 <div class="contact-text">
                     <h2>Thông tin liên hệ</h2>
                     <p>Liên hệ với chúng tôi để nhận được những thông báo mới nhất.</p>
                     <table>
                         <tbody>
                             <tr>
                                 <td class="c-o"><i class="fa fa-map-marker"></i></td>
                                 <td>238 Hoàng Quốc Việt</td>
                             </tr>
                             <tr>
                                 <td class="c-o"><i class="fa fa-phone"></i></td>
                                 <td>0988.88.8888</td>
                             </tr>
                             <tr>
                                 <td class="c-o"><i class="fa fa-envelope"></i></td>
                                 <td>aptech.hotel@gmail.com</td>
                             </tr>
                             <tr>
                                 <td class="c-o"><i class="fa fa-fax"></i></td>
                                 <td>+(12) 345 67890</td>
                             </tr>
                         </tbody>
                     </table>
                 </div>
             </div>
             <div class="col-lg-7 offset-lg-1">
                 <form action="#" class="contact-form" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" placeholder="Tên của bạn" name="name">
                        </div>
                        <div class="col-lg-6">
                            <input type="text" placeholder="Email của bạn" name="email">
                        </div>
                        <div class="col-lg-12">
                            <textarea placeholder="Tin nhắn của bạn" name="message"></textarea>
                            <button type="submit" id="submit-contact">Gửi liên hệ</button>
                        </div>
                    </div>
                 </form>
             </div>
         </div>
         <div class="map">
             <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.0606825994123!2d-72.8735845851828!3d40.760690042573295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89e85b24c9274c91%3A0xf310d41b791bcb71!2sWilliam%20Floyd%20Pkwy%2C%20Mastic%20Beach%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1578582744646!5m2!1sen!2sbd" height="470" style="border:0;" allowfullscreen=""></iframe>
         </div>
     </div>
 </section>
 @stop()

@section('js')
    <script>
        $(document).ready(function() {
            $("#submit-contact").click(function(e){
                e.preventDefault();
                var data = $(".contact-form").serialize();
                $.ajax({
                    url : "{{route('client.contact')}}",
                    type : "POST",
                    data : data,
                    success : function(res){
                        if(res.status==false){
                            Swal.fire({
                                html: res.message,
                                icon: res.icon
                            });
                        }
                        if(res.status=='success'){
                            Swal.fire({
                                html: res.message,
                                icon: res.icon
                            });
                            $('.contact-form').trigger("reset");
                        }
                    }
                });
            });
        });
    </script>
@endsection