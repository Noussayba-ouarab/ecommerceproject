<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>navbar</title>
   @include('links')
</head>

<body>

   <div class="container">
      <div class="header_section_top">
         <div class="row">
            <div class="col-sm-12">
               <div class="custom_menu">
                  <ul>
                     <li><a href="{{url('/add')}}">add product</a></li>
                     <li><a href="{{url('/')}}">Home</a></li>
                     <li><a href="{{url('/afficheritems')}}">My products</a></li>
                     <li><a href="">payment</a></li>
                     <li><a href="#">Customer Service</a></li>
                     <li>
                        <!-- Include the Livewire component -->
                        @livewire('CartIcon')
</li>
                  </ul>
                  
                  <div class="login_menu">
                     
                     <!-- <ul>
                     
                        <li><a href="" id="market-icon">
                              <i class="fa fa-shopping-cart" aria-hidden="true"></i>


                              <span class="padding_10" id="item-count">

                                 {{ session('sum', 1) }}
                              </span>


                           </a>
                        </li>

                        <li><a href="#">
                              <i class="fa fa-user" aria-hidden="true"></i>
                              <span class="padding_10">Cart</span></a>
                        </li>
                     </ul> -->
                  </div>

               </div>
            </div>
         </div>
      </div>
   </div>




   <script>
      // if (session(sum > 0)) {
      //     document.getElementById('item-count').style.display = 'inline';
      // } else {
      //     document.getElementById('item-count').style.display = 'none';
      // }
      // Fetch notification count and update market icon
      function updateNotificationCount() {

         // Make an AJAX request to fetch notification count from the server
         fetch('/notifications/count')
            .then(response => response.json())
            .then(data => {
               // Update the item count inside the market icon
               //console.log('ggggg');
               document.getElementById('item-count').textContent = data.count;
               console.log(response);
            })
            .catch(error => {
               console.error('Error fetching notification count:', error);
            });
      }

      // Call the function to update notification count initially
      updateNotificationCount();

      // Optionally, you can set a timer to periodically update the notification count
      setInterval(updateNotificationCount, 5000); // Update every 5 seconds
   </script>

</body>

</html>