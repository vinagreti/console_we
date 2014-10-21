// Dialog
// Classe de dialogs
// Author: Bruno da Silva João
// https://github.com/vinagreti
we_dialog = new function() {

    var self = this;

    var modalHTML = '<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="we_dialog_modal" aria-hidden="true">';
      modalHTML += '<div class="modal-dialog">';
        modalHTML += '<div class="modal-content">';
          modalHTML += '<div class="modal-header">';
            modalHTML += '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
            modalHTML += '<h4 class="modal-title" id="we_dialog_modal"></h4>';
          modalHTML += '</div>';
          modalHTML += '<div class="modal-body">';
          modalHTML += '</div></br>';
          modalHTML += '<div class="modal-footer">';
            modalHTML += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>';
            modalHTML += '<button type="button" class="btn btn-primary">OK</button>';
          modalHTML += '</div>';
        modalHTML += '</div>';
      modalHTML += '</div>';
    modalHTML += '</div>';

    var radio_box = '<div class="radio">';
      radio_box += '<label>';
        radio_box += '<input type="radio" name="optionsRadios">';
        radio_box += '<span class="radio_box_text"></span>';
      radio_box += '</label>';
    radio_box += '</div>';

    // confirmation box
    self.confirm = function( title, message, callback ){

        var confirm_modal = $(modalHTML).clone();

        confirm_modal.find(".modal-title").html( title );

        confirm_modal.find(".modal-body").html( message );

        confirm_modal.find(".btn-primary").on("click", function(){

            confirm_modal.modal("hide");

            callback( true );

        });

        confirm_modal.modal();

    };

    // confirmation box
    self.radio = function( title, options, callback ){

        var radio_modal = $(modalHTML).clone();

        radio_modal.find(".modal-title").html( title );

        radio_modal.find(".modal-body").append('<div class="col-sm-6 radio_boxes_left"></div>');

        radio_modal.find(".modal-body").append('<div class="col-sm-6 radio_boxes_rigth"></div>');

        $.each( options, function( index, option ){

            var radio_option = $(radio_box).clone();

            radio_option.find("input").attr("id", option.id).attr("value", option.id);

            radio_option.find(".radio_box_text").html(option.name);

            if (index % 2 == 0) {

                // insere o novo checkbox na coluna da esquerda
                radio_modal.find(".radio_boxes_left").append( radio_option );

            } else {

                // insere o novo checkbox na coluna da direita
                radio_modal.find(".radio_boxes_rigth").append( radio_option );

            }

        });

        radio_modal.find(".btn-primary").on("click", function(){

            var selected = radio_modal.find('input[name=optionsRadios]:checked').val();

            callback( selected );

            radio_modal.modal("hide");

        });

        radio_modal.modal();
        
    };

}