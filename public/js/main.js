
// $(document).on('click', '.searchCity', function (event) {
// 	const getCity = document.getElementById('searchCity').value;
// 	console.log(getCity);
// });

//$(document).ready(function() {
	let seachCityes = document.getElementById("searchCity");
	if (seachCityes) {
		seachCityes.oninput = function() {searchCity()};
	}
//});

function searchCity(){
	const nameCity = document.getElementById('searchCity').value;
	const cityList = document.getElementById('searchCityList');
	//видалити дочірні елементи перед додаванням нових
	while(cityList.firstChild) {
		cityList.removeChild(cityList.firstChild);
	}

	if (nameCity.length>2) {
		//console.log(nameCity);
		$.ajax({
			url: '/seachCity',
			type: 'GET',
            data: {
                nameCity: nameCity,
            },
            dataType: 'json',
            success: function (data) {
            	if (data.status) {
            		console.log(data);
            		let addedCityes = [];
            		data.cityes.forEach(function addCity(onecity) {

            			//Add in datalist
            			if (!addedCityes.includes(onecity.city)) {

            			    let option = document.createElement('option');
                            option.value = onecity.city;
                            cityList.appendChild(option);
                            addedCityes.push(onecity.city);

                        }
                         if (!addedCityes.includes(onecity.settlement)) {

                            //add settlement
                            option = document.createElement('option');
                            option.value = onecity.settlement;
                            cityList.appendChild(option);
                            addedCityes.push(onecity.settlement);

                        }
                        //console.log(onecity.city);
            		})
            	} else {
            		
            		//if we don't have hotel in this city
            		//потрібно буде замінити option на окреме повідомлення
            		let option = document.createElement('option');
                    option.value = 'на жаль, в даному місті, ще не зараєстровано готелів';
                    cityList.appendChild(option);
            	}
            },
            error: function(request, status, errorT) {
            	console.log(errorT);
            }
		})
	}
};

$(document).on('click', '.searchHotels', function (event) {
	const nameCity = document.getElementById('searchCity').value;
	const dateFrom = document.getElementById('dateFromHome').value;
	const dateTo = document.getElementById('dateToHome').value;
	// const count_adult = document.getElementById('count_adult').value;
	// const count_children = document.getElementById('count_children').value;
    const seachResult = document.getElementById('seachResult');

	$.ajax({
			url: '/searchHotels',
			type: 'GET',
            data: {
                nameCity: nameCity,
                dateFrom: dateFrom,
                dateTo: dateTo
            },
            dataType: 'json',
            success: function (data) {
                while(seachResult.firstChild) {
                    seachResult.removeChild(seachResult.firstChild);
                }
            	
            	console.log(data);
            	if (data.status) {
            		data.hotels.forEach(function addCity(hotel) {
            			const url = routeShowHotel.replace(':id', hotel.userhotel_id).replace(':dateFrom', dateFrom).replace(':dateTo', dateTo);
            		    let newDiv = document.createElement("div");
                        newDiv.innerHTML = '<div class="card mb-3" style="max-width: 640px;">'+
                                         '<div class="row g-0">'+
                                           '<div class="col-md-4">'+
                                             '<a href="'+url+'"><img src="'+hotel.photo+'" class="img-fluid rounded-start" alt="..."></a>'+
                                           '</div>'+
                                           '<div class="col-md-8">'+
                                             '<div class="card-body">'+
                                               '<a href="'+url+'"><h5 class="card-title">'+hotel.hotel_name+'</h5></a>'+
                                               '<p class="card-text"><small class="text-muted">'+hotel.city +', '+hotel.settlement+'</small></p>'+
                                               '<p class="card-text">'+hotel.description+'</p>'+
                                               '<p class="card-text"><small class="text-muted">'+hotel.aditional_services+'</small></p>'+
                                             '</div>'+
                                           '</div>'+
                                         '</div>'+
                                       '</div>';
                        seachResult.appendChild(newDiv);
                    })
            	} else {
                    while(seachResult.firstChild) {
                        seachResult.removeChild(seachResult.firstChild);
                    }
                    let newDiv = document.createElement("div");
                    newDiv.innerHTML = '<p class="text-danger">'+data.message+'<p>';
                    seachResult.appendChild(newDiv);
                }
            },
            error: function(request, status, errorT) {
            	console.log(errorT);
            }
        })
})

$(document).on('click', '.openBookModal', function (event) {

    $('#alert-danget-for-add-reservation').hide();
    $('#first_name').val('');
    $('#last_name').val('');
    $('#email').val('');
    $('#phone').val('');

    //для бронювання кімнати потрібно буде додати можливість зміни дати,
    //але потрібно буде передивитись можливість перевірки вільних кімнат
    //при зміні дати, щоб не було можливості бронювати зайву кількість

	const room_id = $(this).data('id');
	const locationParametr = $(location).prop('pathname').split('/');
	const dateTo = locationParametr.pop();
	const dateFrom = locationParametr.pop();
	console.log(room_id);

	if(room_id != undefined) {
		$.ajax({
        url: '/getroominformation/'+room_id,
        type: 'GET',
        // data: {
        //     id: room_id,
        // },
        dataType: 'json',
        success: function (data) {
        	if (data.status) {
        		const roomPhotoElement = document.getElementById('room_photo_modal');
        		const aboutHotelElement = document.getElementById('information_about_hotel_modal');
        		const roomPhoto = document.getElementById('photo_room_'+room_id);

                while(roomPhotoElement.firstChild) {
                    roomPhotoElement.removeChild(roomPhotoElement.firstChild);
                }
                while(aboutHotelElement.firstChild) {
                    aboutHotelElement.removeChild(aboutHotelElement.firstChild);
                }

        		$('#room_id').val(room_id);

        		// if (roomPhotoElement.childElementCount == 0) {
        		
        		if (roomPhoto) {
        			let newDiv = document.createElement("div");
        			newDiv.innerHTML = '<img src="'+roomPhoto.getAttribute('src')+'" class="img-fluid rounded-start" width="100p" height="108p" alt="'+room_id+'">';
        			roomPhotoElement.appendChild(newDiv);

        			//console.log(roomPhotoElement)
        		}
        		 let newDiv1 = document.createElement("div");
        		 newDiv1.innerHTML = '<h3>'+data.information.hotel_name+'</h3>';
        		 aboutHotelElement.appendChild(newDiv1);

                 let newDiv2 = document.createElement("div");
        		 newDiv2.innerHTML = '<h6>'+data.information.address+'</h6>';
        		 aboutHotelElement.appendChild(newDiv2);

        		 let newDiv3 = document.createElement("div");
        		 newDiv3.innerHTML = '<h6> Дата заїзду: '+dateFrom+' Дата виїзду: '+dateTo+'</h6>';
        		 aboutHotelElement.appendChild(newDiv3);
        		// }
        		 $('#ModalWindow').modal('show');
        	} else {
                reportAnErrorForModalWindow(data.information, 'alert-danget-for-add-reservation')
            }
        },
        error: function(request, status, errorT) {
        	console.log(errorT);
        }
    })
	} else {}
})

$(document).on('click', '.book_room', function (event) {

	//додати перевірку заповненості користувацьких полів

	const locationParametr = $(location).prop('pathname').split('/');
	const dateTo = locationParametr.pop();
	const dateFrom = locationParametr.pop();

	const room_id = $('#room_id').val();
	const fname = $('#first_name').val();
	const lname = $('#last_name').val();
	const email = $('#email').val();
	const phone = $('#phone').val();

	let token = $("input[name='_token']").val();


	$.ajax({
        url: '/bokingroom',
        type: 'POST',
        data: {
        	_token: token,
            id: room_id,
            first_name: fname,
            last_name: lname,
            email: email,
            phone: phone,
            date_from: dateFrom,
            date_to: dateTo
        },
        dataType: 'json',
        success: function (data) {
        	if (data.status) {
        		$('#ModalWindow').modal('hide');
        		$('#ModalWindowReserve').modal('show');
        		console.log(data.id);
        	} else {
            //тут помилки обробляються через validate
            reportAnErrorForModalWindow(data.message, 'alert-danget-for-add-reservation');
            }
        },
        error: function(request, status, errorT) {
        	console.log(errorT);
        }
    })
})


document.addEventListener("DOMContentLoaded", function (event) {
    if (location.pathname == '/userbookedroom') {
        //завантажити бронювання з бд при зміні проміжку дат
        $('input[name="daterange"]').daterangepicker({
          opens: 'left'
        }, function(start, end, label) {
              datePicerInput(start, end);
                });

        // при завантаженні сторінки отримувати дані з БД і створити список бронювань card
        // в файлі userbookedrroms.blade  при відкритті, datapiker заповнюється - сьогодні+(-)10днів
        let start = moment().subtract(10, 'days');
        let end = moment().add(10, 'days');
        // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        datePicerInput(start, end);

        // при зміні дати потрібно перевіряти проміжок на корректність
        document.getElementById("dateFrom").onchange = function() {
            let dateFrom = moment.utc($('#dateFrom').val());
            let dateTo = moment.utc($('#dateTo').val());
            if (dateFrom > dateTo) {
                $('#dateTo').val(dateFrom.add(1, 'days').format("YYYY-MM-DD"));
            }
            //тут пізніше передивитись, потрібно буде зробити заповнення доступних
            //кімнат по даті, перевірити умову
            // if (dateTo._d !== 'Invalid Date' && dateFrom._d !== 'Invalid Date') {
            //     console.log(dateTo._d == 'Invalid Date');
            //     console.log(dateFrom._d == 'Invalid Date');
            //     // fillListUserRoom('');
            // }
        };

        document.getElementById("dateTo").onchange = function() {
            let dateFrom = moment.utc($('#dateFrom').val());
            let dateTo = moment.utc($('#dateTo').val());
            if (dateFrom > dateTo) {
                $('#dateFrom').val(dateTo.subtract(1, 'days').format("YYYY-MM-DD"));
            }
        };
    }
  });


function datePicerInput(start, end) {

  
    // console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

    const cardBookedRoom = document.getElementById('card-booked-room');
    //видалити дочірні елементи перед додаванням нових
    while(cardBookedRoom.firstChild) {
        cardBookedRoom.removeChild(cardBookedRoom.firstChild);
    }

    $.ajax({
      url: '/searchBookedRooms/'+start.format('YYYY-MM-DD')+'/'+end.format('YYYY-MM-DD'),
      type: 'GET',
            // data: {
            //     dateFrom: start.format('YYYY-MM-DD'),
            //     dateTo: end.format('YYYY-MM-DD')
            // },
            dataType: 'json',
            success: function (data) {
              // console.log(data);
              if (data.status) {

                // const cardBookedRoom = document.getElementById('card-booked-room');

                data.booked_rooms.forEach(function addCardBookedRoom(bookedRoom) {
                  let newDiv = document.createElement("div");
                  newDiv.classList.add('card');
                  newDiv.classList.add('mb-3');
                  newDiv.setAttribute('id', bookedRoom.id);
                  newDateFrom = new Date(bookedRoom.date_from).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});
                  newDateTo = new Date(bookedRoom.date_to).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});

                  newDiv.innerHTML = '<h5 class="card-header">'+'З '+newDateFrom+' по '+newDateTo+'</h5>'+
                                      '<div class="card-body">'+
                                        '<h5 class="card-title">'+bookedRoom.name+'</h5>'+
                                        '<p class="card-text">'+bookedRoom.first_name + ' '+bookedRoom.last_name+'</p>'+
                                        '<p class="card-text">'+'E-mail: '+bookedRoom.email+'</p>'+
                                        '<p class="card-text">'+'Тел.: '+bookedRoom.phone+'</p>'+
                                        (bookedRoom.confirmed ? '<button class="btn btn-secondary openModalForCancelOrConfirm" id="button_br'+bookedRoom.id+'" type="button" data-id="'+
                                            bookedRoom.id+'" data-target="cancel">'+'Відмінити'+'</button>' : '<button class="btn btn-primary openModalForCancelOrConfirm" id="button_br'+bookedRoom.id+
                                            '" type="button" data-id="'+bookedRoom.id+'" data-target="confirm">'+'Підтвердити'+'</button>')+
                                        '<button class="btn btn-danger openModalForDelete" id="delete'+bookedRoom.id+'" type="button" data-id="'+bookedRoom.id+'" data-target="delete" style="float: right;">'+'Видалити'+'</button>'+
                                        '<button class="btn btn-info openModalForChange" data-id="'+bookedRoom.id+'" data-target="change" id="change'+bookedRoom.id+'" type="button" style="float: right;">'+'Змінити'+'</button>'+
                                      '</div>';

                  cardBookedRoom.appendChild(newDiv);
                })

                
              } else {
                console.log(data.message);
              }
            },
            error: function(request, status, errorT) {
              console.log(errorT);
            }
          })
}

$(document).on('click', '.openModalForCancelOrConfirm', function (event) {
    const booked_room_id = $(this).data('id');
    const target = document.getElementById('button_br'+booked_room_id).dataset.target;
    console.log(target);

    $('.hidden_booked_room_id').val(booked_room_id);

    $('#alert-danget-for-cancel-or-confirm').hide();

    if (target=='confirm') {
        $('.CancelOrConfirm').text('Ви дійсно хочете підтвердити бронювання?');
        $('#cancelReservation').hide();
        $('#deletReservation').hide();
        $('.CancelOrConfirm').show();
        $('#confirmReservation').show();
        $('#ModalWindowConfirmOrCancelBookedRoom').modal('show');
        return true;
    }

        $('.CancelOrConfirm').text('Ви дійсно хочете відмінити бронювання?');
        $('#confirmReservation').hide();
        $('#deletReservation').hide();
        $('.CancelOrConfirm').show();
        $('#cancelReservation').show();
        $('#ModalWindowConfirmOrCancelBookedRoom').modal('show');

})

$(document).on('click', '.openModalForDelete', function (event) {
    const booked_room_id = $(this).data('id');
    const target = document.getElementById('delete'+booked_room_id).dataset.target;
    console.log(target);

    $('.hidden_booked_room_id').val(booked_room_id);

    $('#alert-danget-for-cancel-or-confirm').hide();

    $('.CancelOrConfirm').text('Ви дійсно хочете видалити бронювання?');
    $('#cancelReservation').hide();
    $('#confirmReservation').hide();
    $('.CancelOrConfirm').show();
    $('#deletReservation').show();
    $('#ModalWindowConfirmOrCancelBookedRoom').modal('show');
})

$('#confirmReservation').click(function () {

    const booked_room_id = $('#ModalWindowConfirmOrCancelBookedRoom').find('.hidden_booked_room_id').val();

    $.ajax({
      url: '/confirmOrCancelBookedRoom/'+booked_room_id+'/'+'confirm',
      type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    // console.log(data);
                    const button_br = document.getElementById('button_br'+booked_room_id);//$('#card-booked-room').find('#'+booked_room_id);
                    button_br.setAttribute('class', 'btn btn-secondary openModalForCancelOrConfirm');
                    button_br.setAttribute('data-target', 'cancel');
                    button_br.innerHTML = 'Відмінити';
                    $('#ModalWindowConfirmOrCancelBookedRoom').modal('hide');
                } else {
                    // повідомити про помилку
                    reportAnErrorForCancelOrConfirm(data.message);
                }
            },
            error: function(request, status, errorT) {
              console.log(errorT);
            }
        })
})

$('#cancelReservation').click(function () {

    const booked_room_id = $('#ModalWindowConfirmOrCancelBookedRoom').find('.hidden_booked_room_id').val();

    $.ajax({
      url: '/confirmOrCancelBookedRoom/'+booked_room_id+'/'+'cancel',
      type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    // оновити кард
                    const button_br = document.getElementById('button_br'+booked_room_id);
                    button_br.setAttribute('class', 'btn btn-primary openModalForCancelOrConfirm');
                    button_br.setAttribute('data-target', 'confirm');
                    button_br.innerHTML = 'Підтвердити';
                    $('#ModalWindowConfirmOrCancelBookedRoom').modal('hide');
                } else {
                    // повідомити про помилку
                    reportAnErrorForCancelOrConfirm(data.message);
                }
            },
            error: function(request, status, errorT) {
              console.log(errorT);
            }
        })
})

$('#deletReservation').click(function () {

    const booked_room_id = $('#ModalWindowConfirmOrCancelBookedRoom').find('.hidden_booked_room_id').val();

    $.ajax({
      url: '/confirmOrCancelBookedRoom/'+booked_room_id+'/'+'delete',
      type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                    // видалити кард
                    const element = document.getElementById(booked_room_id);
                    element.remove();
                    $('#ModalWindowConfirmOrCancelBookedRoom').modal('hide');
                } else {
                    // повідомити про помилку
                    reportAnErrorForCancelOrConfirm(data.message);
                }
            },
            error: function(request, status, errorT) {
              console.log(errorT);
            }
        })
})

function reportAnErrorForCancelOrConfirm(message) {

    const alertDanger = document.getElementById('alert-danget-for-cancel-or-confirm');

    while(alertDanger.firstChild) {
        alertDanger.removeChild(alertDanger.firstChild);
    }

    let ul = document.createElement('ul');
    ul.innerHTML = '<li>'+message+'</li>' 
    alertDanger.appendChild(ul);
    $('#alert-danget-for-cancel-or-confirm').show();

}

$(document).on('click', '.openModalForChange', function (event) {

    $('#alert-danget-for-add-or-edit').hide();

    const booked_room_id = $(this).data('id');
    const target = $(this).data('target');

    $('.hidden_booked_room_id').val(booked_room_id);
    if (target == 'change') {
        //отримати і заповнити значення бронювання (confirm)
        $.ajax({
            url: '/dataOfBookedRoom/'+booked_room_id,
            type: 'GET',
                  dataType: 'json',
                  success: function (data) {
                      if (data.status) {
                          $('#dateFrom').val(data.booked_room.date_from.slice(0,10));
                          $('#dateTo').val(data.booked_room.date_to.slice(0,10));
                          //переглянути можливість заповення списку доступних кімнат,
                          //щоб список заповнювався перед відкриттям ModalWindow
                          fillListUserRoom(data.booked_room.room_id);
                          $('#first_name_br').val(data.booked_room.first_name);
                          $('#last_name_br').val(data.booked_room.last_name);
                          $('#email_br').val(data.booked_room.email);
                          $('#phone_br').val(data.booked_room.phone);
                          // $('#confirmed').val(data.booked_room.confirmed);
                          document.getElementById("confirmed").checked = (data.booked_room.confirmed == "1" ? true : false);

                          $('#addReservation').hide();
                          $('#editReservation').show();
                          $('#ModalWindowAddOrEdit').modal('show');
                          // $('#UserRoomList').val(data.booked_room.room_id);
      
                          // console.log('room_id = '+data.booked_room.room_id);
      
                          //додати перемикач підтверджено
                      } else {
                          // повідомити про помилку
                      }
                  },
                  error: function(request, status, errorT) {
                    console.log(errorT);
                  }
              })
    } else {
        //очистити поля modalWindow
        $('#UserRoomList').val('');
        $('#dateFrom').val('');
        $('#dateTo').val('');
        $('#first_name_br').val('');
        $('#last_name_br').val('');
        $('#email_br').val('');
        $('#phone_br').val('');
        fillListUserRoom('');
        $('#addReservation').show();
        $('#editReservation').hide();
        $('#ModalWindowAddOrEdit').modal('show');
    }
})

//функція заповнює список доступних до вибору кімнат в залежності від дати
//при створенні або редагуванні бронювань
function fillListUserRoom(room_id) {

    const id = $('.hidden_booked_room_id').val();
    const dateFrom = document.getElementById('dateFrom').value;
    const dateTo = document.getElementById('dateTo').value;
    const userRoomList = $('#UserRoomList').val();

    const roomList = document.getElementById('UserRoomList');
    //видалити дочірні елементи перед додаванням нових
    while(roomList.firstChild) {
        roomList.removeChild(roomList.firstChild);
    }
        //запит доступних кімнат на дату
        $.ajax({
            url: '/getUserRoomsForFillList',
            type: 'GET',
            data: {
                id: id,
                dateFrom: dateFrom,
                dateTo: dateTo
            },
            dataType: 'json',
            success: function (data) {
                if (data.status) {
                  // заповнити список доступних кімнат для бронювання
                  data.rooms.forEach(function addRoom(oneRoom) {
                    // console.log(oneRoom);
                    // console.log(oneRoom.booked_rooms_count < oneRoom.count_rooms);
                    if (oneRoom.booked_rooms_count == undefined || oneRoom.booked_rooms_count < oneRoom.count_rooms) {
                        let option = document.createElement('option');
                        option.value = oneRoom.id;
                        option.innerHTML = oneRoom.name;
                        roomList.appendChild(option);
                    }
                  })
                  // console.log(room_id);
                  $('#UserRoomList').val(room_id);
                    
                } else {
                    // повідомити про помилку
                }
            },
            error: function(request, status, errorT) {
              console.log(errorT);
            }
        })
}

$('#addReservation').click(function () {

    const room_id = $('#UserRoomList').val();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();
    const first_name = $('#first_name_br').val();
    const last_name = $('#last_name_br').val();
    const email = $('#email_br').val();
    const phone = $('#phone_br').val();
    const confirmed = (document.getElementById("confirmed").checked ? 1 : 0);

    let token = $("input[name='_token']").val();

    const CardBookedRoom = document.getElementById('card-booked-room');

    $.ajax({
      url: '/addNewReservation',
      type: 'POST',
      data: {
          _token: token,
          room_id: room_id,
          date_from: dateFrom,
          date_to: dateTo,
          first_name: first_name,
          last_name: last_name,
          email: email,
          phone: phone,
          confirmed: confirmed
      },
      dataType: 'json',
      success: function (data) {
          if (data.status) {
              // додати кард
            let newDiv = document.createElement("div");
                  newDiv.classList.add('card');
                  newDiv.classList.add('mb-3');
                  newDiv.setAttribute('id', data.booked_room.id);
                  newDateFrom = new Date(data.booked_room.date_from).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});
                  newDateTo = new Date(data.booked_room.date_to).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});

                  newDiv.innerHTML = '<h5 class="card-header">'+'З '+newDateFrom+' по '+newDateTo+'</h5>'+
                                      '<div class="card-body">'+
                                        '<h5 class="card-title">'+data.name_room+'</h5>'+
                                        '<p class="card-text">'+data.booked_room.first_name + ' '+data.booked_room.last_name+'</p>'+
                                        '<p class="card-text">'+'E-mail: '+data.booked_room.email+'</p>'+
                                        '<p class="card-text">'+'Тел.: '+data.booked_room.phone+'</p>'+
                                        (data.booked_room.confirmed == 1 ? '<button class="btn btn-secondary openModalForCancelOrConfirm" id="button_br'+data.booked_room.id+'" type="button" data-id="'+
                                            data.booked_room.id+'" data-target="cancel">'+'Відмінити'+'</button>' : '<button class="btn btn-primary openModalForCancelOrConfirm" id="button_br'+data.booked_room.id+
                                            '" type="button" data-id="'+data.booked_room.id+'" data-target="confirm">'+'Підтвердити'+'</button>')+
                                        '<button class="btn btn-danger openModalForDelete" id="delete'+data.booked_room.id+'" type="button" data-id="'+data.booked_room.id+'" data-target="delete" style="float: right;">'+'Видалити'+'</button>'+
                                        '<button class="btn btn-info openModalForChange" data-id="'+data.booked_room.id+'" data-target="change" id="change'+data.booked_room.id+'" type="button" style="float: right;">'+'Змінити'+'</button>'+
                                      '</div>';

                  CardBookedRoom.appendChild(newDiv);
              // console.log(data.result);
              $('#ModalWindowAddOrEdit').modal('hide');
          } else {
            reportAnErrorForModalWindow(data.message, 'alert-danget-for-add-or-edit');
          }
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
 })
})

$('#editReservation').click(function () {

    const id = $('#ModalWindowAddOrEdit').find('.hidden_booked_room_id').val();

    const room_id = $('#UserRoomList').val();
    const dateFrom = $('#dateFrom').val();
    const dateTo = $('#dateTo').val();
    const first_name = $('#first_name_br').val();
    const last_name = $('#last_name_br').val();
    const email = $('#email_br').val();
    const phone = $('#phone_br').val();
    const confirmed = (document.getElementById("confirmed").checked ? 1 : 0);

    let token = $("input[name='_token']").val();

    $.ajax({
      url: '/editNewReservation',
      type: 'POST',
      data: {
          _token: token,
          id: id,
          room_id: room_id,
          date_from: dateFrom,
          date_to: dateTo,
          first_name: first_name,
          last_name: last_name,
          email: email,
          phone: phone,
          confirmed: confirmed
      },
      dataType: 'json',
      success: function (data) {
          if (data.status) {
              // змінити кард
            const cardDiv = document.getElementById(id);
            newDateFrom = new Date(data.booked_room.date_from).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});
            newDateTo = new Date(data.booked_room.date_to).toLocaleString("ru", {day: 'numeric',  month: 'numeric', year: 'numeric'});

            cardDiv.innerHTML = '<h5 class="card-header">'+'З '+newDateFrom+' по '+newDateTo+'</h5>'+
                                      '<div class="card-body">'+
                                        '<h5 class="card-title">'+data.name_room+'</h5>'+
                                        '<p class="card-text">'+data.booked_room.first_name + ' '+data.booked_room.last_name+'</p>'+
                                        '<p class="card-text">'+'E-mail: '+data.booked_room.email+'</p>'+
                                        '<p class="card-text">'+'Тел.: '+data.booked_room.phone+'</p>'+
                                        (data.booked_room.confirmed == 1 ? '<button class="btn btn-secondary openModalForCancelOrConfirm" id="button_br'+data.booked_room.id+'" type="button" data-id="'+
                                            data.booked_room.id+'" data-target="cancel">'+'Відмінити'+'</button>' : '<button class="btn btn-primary openModalForCancelOrConfirm" id="button_br'+data.booked_room.id+
                                            '" type="button" data-id="'+data.booked_room.id+'" data-target="confirm">'+'Підтвердити'+'</button>')+
                                        '<button class="btn btn-danger openModalForDelete" id="delete'+data.booked_room.id+'" type="button" data-id="'+data.booked_room.id+'" data-target="delete" style="float: right;">'+'Видалити'+'</button>'+
                                        '<button class="btn btn-info openModalForChange" data-id="'+data.booked_room.id+'" data-target="change" id="change'+data.booked_room.id+'" type="button" style="float: right;">'+'Змінити'+'</button>'+
                                      '</div>';

            
              // console.log(data.result);
              $('#ModalWindowAddOrEdit').modal('hide');
          } else {
            reportAnErrorForModalWindow(data.message, 'alert-danget-for-add-or-edit');
          }
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
 })
})

function reportAnErrorForModalWindow(messages, id) {

    const alertDanger = document.getElementById(id);

    while(alertDanger.firstChild) {
        alertDanger.removeChild(alertDanger.firstChild);
    }

    if (typeof messages === 'string') {
        let ul = document.createElement('ul');
        ul.innerHTML = '<li>'+messages+'</li>'
        alertDanger.appendChild(ul);
    } else{
        Object.values(messages).forEach(function addError(message) {
            let ul = document.createElement('ul');
            ul.innerHTML = '<li>'+message[0]+'</li>' 
            alertDanger.appendChild(ul);
        });
    }
    $('#'+id).show();

}

$(document).on('click', '.ModalChangePass', function (event) {

    $('#new_pass_lable').hide();
    $('#new_pass_confirmation_lable').hide();
    $('#updatePassword').hide();
    $('#alert-danget-for-change-password').hide();

    $('#pass').val('');
    $('#new_pass').val('');
    $('#new_pass_confirmation').val('');

    $('#old_pass_lable').show();

    $('#ModalWindowChangePass').modal('show');
})

$(document).on('click', '#sendPassword', function (event) {

    const alertDanger = document.getElementById('alert-danget-for-change-password');

    while(alertDanger.firstChild) {
        alertDanger.removeChild(alertDanger.firstChild);
    }

    const password = $('#pass').val();

    const token = $("input[name='_token']").val();

    $.ajax({
      url: '/checkPassword',
      type: 'POST',
      data: {
          _token: token,
          password: password
      },
      dataType: 'json',
      success: function (data) {
        if (data.status) {
            $('#alert-danget-for-change-password').hide();
            $('#old_pass_lable').hide();
            $('#new_pass_lable').show();
            $('#new_pass_confirmation_lable').show();
            $('#updatePassword').show();
        } else {
            // const errorModal = document.getElementById('errorModalChangePass');
            reportAnErrorForModalWindow(data.message, 'alert-danget-for-change-password');
        }
        // console.log(data);
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
  });
})

$(document).on('click', '#updatePassword', function (event) {

    $('#alert-danget-for-change-password').hide();

    const alertDanger = document.getElementById('alert-danget-for-change-password');

    while(alertDanger.firstChild) {
        alertDanger.removeChild(alertDanger.firstChild);
    }

    const password = $('#new_pass').val();
    const password_confirmation = $('#new_pass_confirmation').val();

    const token = $("input[name='_token']").val();

    $.ajax({
      url: '/updatepassword',
      type: 'POST',
      data: {
          _token: token,
          password: password,
          password_confirmation: password_confirmation
      },
      dataType: 'json',
      success: function (data) {
        if (!data.status) {
            reportAnErrorForModalWindow(data.message, 'alert-danget-for-change-password');
        } else {
            location.reload();
        }
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
  });
})

$(document).on('change', '#dateToHome', function (event) {
    let dateFrom = moment.utc($('#dateFromHome').val());
    let dateTo = moment.utc($('#dateToHome').val());
    console.log(dateFrom+'_'+dateTo);
    if (dateFrom > dateTo) {
        $('#dateFromHome').val(dateTo.subtract(1, 'days').format("YYYY-MM-DD"));
    }
})

$(document).on('change', '#dateFromHome', function (event) {
    let dateFrom = moment.utc($('#dateFromHome').val());
    let dateTo = moment.utc($('#dateToHome').val());
    if (dateFrom > dateTo) {
        $('#dateToHome').val(dateFrom.add(1, 'days').format("YYYY-MM-DD"));
    }
})

$(document).on('click', '.openModalForDeleteRoomOrHotel', function (event) {
    const id = $(this).data('id');
    const target = $(this).data('target');
    console.log(target);

    $('.hidden_id').val(id);

    const modalMessage = document.getElementById('DeleteRoomOrHotel');

    while(modalMessage.firstChild) {
        modalMessage.removeChild(modalMessage.firstChild);
    }

    if (target == 'hotel') {
        $('#DeleteRoomOrHotel').text('Ви дійсно хочете видалити готель?');
        $('#deleteHotel').show();
        $('#deleteRoom').hide();
    } else {
        $('#DeleteRoomOrHotel').text('Ви дійсно хочете видалити кімнату?');
        $('#deleteRoom').show();
        $('#deleteHotel').hide();
    }

    $("#ModalWindowForDeleteRoomOrHotel").modal('show');
})

$(document).on('click', '#deleteHotel', function (event) {

    const hotel_id = $('.hidden_id').val();
    const modalMessage = document.getElementById('DeleteRoomOrHotel');

     const token = $("input[name='_token']").val();

    $.ajax({
      url: '/userhotel/'+hotel_id,
      type: 'DELETE',
      data: {
          _token: token
      },
      dataType: 'json',
      success: function (data) {
        if (!data.status) {
            modalMessage.innerHTML = '<p class="text-danger">'+data.message+'</p>';
            $('#deleteHotel').hide();
        } else {
            location.reload();
        }
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
  });
})

$(document).on('click', '#deleteRoom', function (event) {

    const room_id = $('.hidden_id').val();
    const modalMessage = document.getElementById('DeleteRoomOrHotel');

     const token = $("input[name='_token']").val();

    $.ajax({
      url: '/userroom/'+room_id,
      type: 'DELETE',
      data: {
          _token: token
      },
      dataType: 'json',
      success: function (data) {
        if (!data.status) {
            modalMessage.innerHTML = '<p class="text-danger">'+data.message+'</p>';
            $('#deleteRoom').hide();
        } else {
            location.reload();
        }
      },
      error: function(request, status, errorT) {
         console.log(errorT);
       }
  });
})

// $(document).on('click', '#UserRoomList', function (event) {
//     console.log('#UserRoomList');

    
// })