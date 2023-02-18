 <div class="modal fade" id="changeStatusButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
       <div class="modal-content">
         <div class="modal-header">
           <h5 class="modal-title" id="statusChangeFormModalLabel">Change status</h5><span class="orderId"></span>
           <button type="button" class="close" data-dismiss="modal" aria-label="Close">
             <span aria-hidden="true">&times;</span>
           </button>
         </div>

         <form method="post" action="{{ route('admin.agri_license.status') }}">
           @csrf
           <div class="modal-body">
             <div class="hiddenField"></div>
             <div class="form-group">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="status">
                 <option value="">Select</option>
                 @if ($logged_in_user->can('admin.order.order_rmb.edit'))
                 <option value="approved">Approved</option>
                 <option value="waiting-for-approval">Waiting for approval</option>
                 @endif
               </select>
             </div>
           </div>
           <div class="modal-footer justify-content-between">
             <button type="submit" class="btn btn-primary">Save
               changes</button>
           </div>
         </form>

       </div>
     </div>
   </div>
 </div>