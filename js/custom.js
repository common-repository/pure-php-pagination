
jQuery(document).ready(function($){

  $php_pure_pagination = $.noConflict();



  $php_pure_pagination.ajax({
      type: 'POST',
      dataType: 'html',
      url:  $php_pure_pagination('.ppp_list_pagination_list').data('ajax'),
      beforeSend: function(){
         $('.loader_wrap').addClass('active');
      },
      data: {
        action:'pure_php_pagination',
        ppp : $php_pure_pagination('.ppp_list_pagination_list').data('ppp'),
        post_type : $php_pure_pagination('.ppp_list_pagination_list').data('type'),
        page_number : 1,
        category : $php_pure_pagination('.ppp_list_pagination_list').data('cat'),
        get_data: '1',
        maxpages: $php_pure_pagination('.ppp_list_pagination_list').data('maxpages'),

      },
      success: function(data){

         if(data)
         {
           if($php_pure_pagination('.ppp_list_pagination').data('top') == "regular"){

             $php_pure_pagination('.load_more_wrap').removeClass('active');
             $php_pure_pagination('.ppp_list_pagination_list').addClass('active');

           }else if ($php_pure_pagination('.ppp_list_pagination').data('top') == "scroll") {
            $php_pure_pagination('.load_more_wrap').addClass('active');
            $php_pure_pagination('.ppp_list_pagination_list').removeClass('active');
           }
          if($php_pure_pagination('.load_more_wrap_button').length){

            $php_pure_pagination('.load_more_wrap_button').on('click touchstart',function(e){
                var pagenum = $('.ppp_list li').first().data('curpage') + 1;

              $php_pure_pagination('.ppp_list li').first().data('curpage',pagenum);
              $php_pure_pagination.ajax({
                  type: 'POST',
                  dataType: 'html',
                  url:  $php_pure_pagination('.load_more_wrap').data('ajax'),
                  beforeSend: function(){
                     $('.loader_wrap').addClass('active');
                  },
                  data: {
                    action:'pure_php_pagination',
                    ppp : $php_pure_pagination('.load_more_wrap').data('ppp'),
                    post_type : $php_pure_pagination('.load_more_wrap').data('type'),
                    page_number :pagenum,
                    category : $php_pure_pagination('.load_more_wrap').data('cat'),
                    get_data: '1',
                    maxpages: $php_pure_pagination('.load_more_wrap').data('maxpages'),

                  },
                  success: function(data){
                     if(data)
                     {

                       if(pagenum == $php_pure_pagination('.ppp_list_pagination_list').data('maxpages')){
                        $php_pure_pagination('.ppp_list_pagination .load_more_wrap').css('display','none');
                       }
                       if($php_pure_pagination('.ppp_list_pagination').data('top') == "regular"){

                         $php_pure_pagination('.load_more_wrap').removeClass('active');
                         $php_pure_pagination('.ppp_list_pagination_list').addClass('active');

                       }else if ($php_pure_pagination('.ppp_list_pagination').data('top') == "scroll") {
                        $('.load_more_wrap').addClass('active');
                        $('.ppp_list_pagination_list').removeClass('active');
                       }

                     $php_pure_pagination('.ppp_list').append(data);
                     $php_pure_pagination('.loader_wrap').removeClass('active');
                     }

                  },
                  error : function(jqXHR, textStatus, errorThrown) {
                      console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                  }
              });

             e.preventDefault();
            });
          }
         $php_pure_pagination('.ppp_list').empty();
         $php_pure_pagination('.ppp_list').append(data);
            $('.ppp_list_pagination_list li a').each(function(index,el){
                if($(el).text() == $('.ppp_list li').first().data('curpage') ){
                  $php_pure_pagination(el).addClass('active');
                }
                else{
                    $php_pure_pagination(el).removeClass('active');
                }
            });

          $php_pure_pagination('.loader_wrap').removeClass('active');
         }

      },
      error : function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
      }
  });

  $php_pure_pagination('.ppp_list_pagination_list a.pagination_link').each(function(index,el){

   $php_pure_pagination(el).on('touchstart click',function(e){
     var pagenum = parseInt($(this).data('num'),10);
     if(pagenum == 1){
       pagenum == 1;
     }else if (pagenum == $php_pure_pagination('.ppp_list_pagination_list').data('maxpages')) {
       pagenum == $php_pure_pagination('.ppp_list_pagination_list').data('maxpages');
     }

     $php_pure_pagination.ajax({
         type: 'POST',
         dataType: 'html',
         url:  $php_pure_pagination('.ppp_list_pagination_list').data('ajax'),
         beforeSend: function(){
            $php_pure_pagination('.loader_wrap').addClass('active');
         },
         data: {
           action:'pure_php_pagination',
           ppp : $php_pure_pagination('.ppp_list_pagination_list').data('ppp'),
           post_type : $php_pure_pagination('.ppp_list_pagination_list').data('type'),
           page_number :pagenum,
           category : $php_pure_pagination('.ppp_list_pagination_list').data('cat'),
           get_data: '1',
           maxpages: $php_pure_pagination('.ppp_list_pagination_list').data('maxpages'),

         },
         success: function(data){
            if(data)
            {
              if($php_pure_pagination('.ppp_list_pagination').data('top') == "regular"){

                $('.load_more_wrap').removeClass('active');
                $('.ppp_list_pagination_list').addClass('active');

              }else if ($php_pure_pagination('.ppp_list_pagination').data('top') == "scroll") {
               $('.load_more_wrap').addClass('active');
               $('.ppp_list_pagination_list').removeClass('active');
              }
            $php_pure_pagination('.ppp_list').empty();
            $php_pure_pagination('.ppp_list').append(data);
            $php_pure_pagination('.ppp_list_pagination_list li a').each(function(index,el){
                if($php_pure_pagination(el).text() == $('.ppp_list li').first().data('curpage') ){
                  $php_pure_pagination(el).addClass('active');
                }
                else{
                    $php_pure_pagination(el).removeClass('active');
                }
            });
            $php_pure_pagination('.loader_wrap').removeClass('active');
            }

         },
         error : function(jqXHR, textStatus, errorThrown) {
             console.log(jqXHR + " :: " + textStatus + " :: " + errorThrown);
         }
     });

    e.preventDefault();
   });

  });
});
