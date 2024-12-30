


<a href="javascript:void(0)" data-tag ="mine" class="mail-list-item ticket-tag">
    <span class="ri-user-3-line me-2 text-info">
   </span>
   <span  class="mail-list-link  " data-type="label">
       {{translate('Mine')}}
   </span>
    <span class="badge badge-soft-danger ms-auto">
         {{$tagsCounter->mine }}
    </span>
</a>

<a href="javascript:void(0)"  data-tag ="assign" class="mail-list-item ticket-tag ">

    <span class="ri-group-line me-2 text-success">
   </span>
   <span class="mail-list-link" data-type="label">
       {{translate('Assigned')}}
   </span>
    <span class="badge badge-soft-danger ms-auto">
        {{$tagsCounter->assigned }}
    </span>
</a>

<a href="javascript:void(0)"  data-tag ="unassign" class="mail-list-item ticket-tag ">
    <span class="ri-user-unfollow-line me-2 text-danger">
   </span>
   <span class="mail-list-link" data-type="label">
       {{translate('Unassigned')}}
   </span>
    <span class="badge badge-soft-danger ms-auto">
        {{$tagsCounter->unassigned }}
    </span>
</a>
