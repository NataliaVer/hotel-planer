<div class="modal" id="ModalWindow" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Забронювати кімнату</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="container">
      <div class="row">
        <div class="room_photo_modal" id="room_photo_modal">
        </div>
        <div class="information_about_hotel_modal" id="information_about_hotel_modal"></div>
      </div>
      </div>

      <form method="post" class="post">
        @csrf
      <input type="hidden" name="room_id" id="room_id" class="hidden_room_id" value="">

      <div class="modal-body">

        <div class="form-group">
          <label for="name">Ім'я</label>
          <input type="name" name="first_name" class="form-control" id="first_name">
        </div>
        <div class="form-group">
          <label for="last_name">Прізвище</label>
          <input type="name" name="last_name" class="form-control" id="last_name">
        </div>

        <div class="form-group">
          <label for="email">Електронна адреса</label>
          <input type="email" name="email" class="form-control" id="email">
        </div>

        <div class="form-group">
          <label for="phone">Телефон</label>
          <input type="phone" name="phone" class="form-control" id="phone">
        </div>

        <div class="errormodal"></div>
        <!-- додати обробку помилок -->
        </div>
        <div class="alert alert-danger" id="alert-danget-for-add-reservation"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
        <button type="button" class="btn btn-primary book_room" id="book_room">Забронювати</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- ModalWindowReserve -->

<div class="modal" id="ModalWindowReserve" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Кімнату заброньовано</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

        <p>Очікуйте дзвінка від оператора для підтвердження бронювання</p>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Ок</button>
      </div>
    
    </div>
  </div>
</div>
</div>

<!-- ModalWindowConfirmOrCancelBookedRoom -->

<div class="modal" id="ModalWindowConfirmOrCancelBookedRoom" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Підтвердити дію</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="post">
        @csrf
        <input type="hidden" name="hidden_booked_room_id" class="hidden_booked_room_id" value="">

        <div class="modal-body">
          <div class="CancelOrConfirm ml-3"></div>
          <div class="alert alert-danger" id="alert-danget-for-cancel-or-confirm"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
          <button type="button" class="btn btn-primary confirmReservation" id="confirmReservation">Підтвердити</button>
          <button type="button" class="btn btn-danger cancelReservation" id="cancelReservation">Відмінити</button>
          <button type="button" class="btn btn-danger deletReservation" id="deletReservation">Видалити</button>
        </div>
      </form>
    
  </div>
</div>
</div>

<!-- ModalWindowForAddOrEdit -->

<div class="modal" id="ModalWindowAddOrEdit" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Дані бронювання</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="post">
        @csrf
        <input type="hidden" name="hidden_booked_room_id" class="hidden_booked_room_id" value="">

        <div class="modal-body">

        <div class="form-group">
          <label for="dateFrom">Дата з</label>
          <input type="date" name="dateFrom" class="form-control" id="dateFrom">
        </div>
        <div class="form-group">
          <label for="dateTo">Дата до</label>
          <input type="date" name="dateTo" class="form-control" id="dateTo">
        </div>

        <div class="form-group">
          <label for="UserRoomList">Кімната</label>
          <select name="UserRoomList" class="form-control" id="UserRoomList" required="required">

          </select>
        </div>

        <!-- <div class="modal-body"> -->
          <div class="form-group">
          <label for="name">Ім'я</label>
          <input type="name" name="first_name" class="form-control" id="first_name_br">
        </div>
        <div class="form-group">
          <label for="last_name">Прізвище</label>
          <input type="name" name="last_name" class="form-control" id="last_name_br">
        </div>

        <div class="form-group">
          <label for="email">Електронна адреса</label>
          <input type="email" name="email" class="form-control" id="email_br">
        </div>

        <div class="form-group">
          <label for="phone">Телефон</label>
          <input type="phone" name="phone" class="form-control" id="phone_br">
        </div>

        <div class="form-group">
          <label for="confirmed">Підтверджено</label>
          <input type="checkbox" name="confirmed" id="confirmed" value="0">
        </div>

        <div class="errormodalAddOrEdit"></div>

      <!-- </div> -->
        </div>
        <div class="alert alert-danger" id="alert-danget-for-add-or-edit"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
          <button type="button" class="btn btn-primary addReservation" id="addReservation">Зберегти</button>
          <button type="button" class="btn btn-primary editReservation" id="editReservation">Зберегти</button>
        </div>
      </form>
    
  </div>
</div>
</div>

<!-- ModalChangePass -->

<div class="modal" id="ModalWindowChangePass" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Дані бронювання</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('updatepassword') }}" method="post" class="post">
        @csrf
        <div class="modal-body">

        <!-- <div class="modal-body"> -->
          <div class="form-group" id="old_pass_lable">
          <label for="pass">Введіть старий пароль</label>
          <input type="password" name="pass" class="form-control" id="pass">
          <div class="d-grid gap-2 col-4 mx-auto mt-3">
            <button type="button" class="btn btn-primary sendPassword" id="sendPassword">Змінити</button>
          </div>
        </div>
        <div class="form-group" id="new_pass_lable">
          <label for="new_pass">Введіть новий пароль</label>
          <input type="password" name="new_pass" class="form-control" id="new_pass">
        </div>

        <div class="form-group" id="new_pass_confirmation_lable">
          <label for="new_pass_confirmation">Повторіть новий пароль</label>
          <input type="password" name="new_pass_confirmation" class="form-control" id="new_pass_confirmation">
        </div>

        <!-- <div class="errormodal" id="errorModalChangePass"></div> -->

      <!-- </div> -->
        </div>
        <div class="alert alert-danger" id="alert-danget-for-change-password"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
          <button type="button" class="btn btn-primary updatePassword" id="updatePassword">Зберегти</button>
        </div>
      </form>
    
  </div>
</div>
</div>

<!-- ModalWindowForDeleteRoomOrHotel -->

<div class="modal" id="ModalWindowForDeleteRoomOrHotel" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tittleModalLabel">Підтвердити дію</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" class="post">
        @csrf
        <input type="hidden" name="hidden_id" class="hidden_id" value="">

        <div class="modal-body">
          <div class="DeleteRoomOrHotel ml-3" id="DeleteRoomOrHotel"></div>
          <!-- <div class="alert alert-danger" id="alert-danget-for-cancel-or-confirm"></div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
          <button type="button" class="btn btn-danger deleteHotel" id="deleteHotel">Видалити</button>
          <button type="button" class="btn btn-danger deleteRoom" id="deleteRoom">Видалити</button>
        </div>
      </form>
    
  </div>
</div>
</div>