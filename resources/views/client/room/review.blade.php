<style>
    .pagination{
        margin-bottom: 50px
    } 
    .pagination li{
        margin-right: 5px;
    }

    .pagination .page-item.active .page-link{
        background-color: #dfa974;
        border-color:#dfa974;
    }
    .pagination .page-link{
        color: black;
    }
</style>
@foreach($reviews as $review)
<div class="ri-text mb-3">
    <div id="rateYo-{{$review->id}}" class="float-right"></div>
    <h5 class="font-weight-bold mb-3">{{$review->customer_name}}</h5>
    <p class="mb-2">{{$review->review}}</p>
    <span>{{$review->created_at->format('d-m-Y')}}</span>
</div>
<script>
    $(function () {
        $("#rateYo-"+"{{$review->id}}").rateYo({
            rating: "{{$review->rating}}",
            readOnly: true,
            starWidth: "20px"
        })
    });
</script>
@endforeach
<br>
<div class="pagination float-left">
    {{$reviews->links()}}
</div>