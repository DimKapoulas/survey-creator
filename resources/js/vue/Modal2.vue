<template>
<div>
    <!-- <link rel="stylesheet" type="text/css" href="/style.css" /> -->
    <!-- template for the modal component -->
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">

              <div class="modal-header">
                <slot name="header">
                  default header
                </slot>
              </div>

              <div class="modal-body">
                <slot name="body">
                  default body
                </slot>
              </div>

              <div class="modal-footer">
                <slot name="footer">
                  default footer
                  <button class="modal-default-button" @click="$emit('close')">
                    OK
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </script>
</div>


<!-- button -->

</template>

    <script src="https://unpkg.com/vue"></script>
    <script type="text/x-template" id="modal-template">

