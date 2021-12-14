<div class="h-screen  py-20 px-3">
    <div class="container mx-auto">
        <div class="max-w-sm mx-auto md:max-w-lg">
            <div class="w-full">
                <div class="bg-white h-64 py-3 rounded text-center">
                    <h4 class="text-3xl font-extrabold text-gray-700 tracking-tight sm:text-4xl">
                        Verify your Email
                    </h4>
                    <p class="flex flex-col mt-6 mx-auto max-w-2xl text-lg text-gray-600">
                        <span>Enter the OTP you received at</span>
                        <span class="font-bold">
                            <?php
                            [$name, $host] = explode("@", $data["email"], 2);
                            echo substr($name, 0, 5) . "...@" . $host;
                            ?>
                        </span>
                    </p>
                    <form action="" method="POST">
                        <div id="otp" class="flex flex-row justify-center text-center px-2 mt-5">
                            <input class="hidden" name="email" value="<?php echo $data["email"] ?>" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="first" id="first" maxlength="1" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="second" id="second" maxlength="1" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="third" id="third" maxlength="1" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="fourth" id="fourth" maxlength="1" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="fifth" id="fifth" maxlength="1" />
                            <input class="m-2 border border-gray-600 h-10 w-10 text-center form-control rounded" type="text" name="sixth" id="sixth" maxlength="1" />
                        </div>
                        <?php if ($data["wrong_otp"]) echo "<p class='text-red-500'>please double check the entered OTP</p>" ?>
                        <div class="flex items-center justify-center text-center mt-2">
                            <span class="cursor-pointer font-bold text-blue-700 hover:text-blue-900">Resend OTP</span>
                            <button type="submit" class="ml-6 block rounded-md border border-transparent px-5 py-2 bg-green-500 text-base font-medium text-white shadow hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 sm:px-4">Verify</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        function OTPInput() {
            const inputs = document.querySelectorAll('#otp > *[id]');
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].addEventListener('keydown', function(event) {
                    if (event.key === "Backspace") {
                        inputs[i].value = '';
                        if (i !== 0) inputs[i - 1].focus();
                    } else {

                        if (i === inputs.length - 1 && inputs[i].value !== '') {
                            return true;
                        } else if (event.keyCode > 47 && event.keyCode < 58) {
                            inputs[i].value = event.key - 48;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        } else if (event.keyCode > 95 && event.keyCode < 106) {
                            inputs[i].value = event.keyCode - 96;
                            if (i !== inputs.length - 1) inputs[i + 1].focus();
                            event.preventDefault();
                        }
                    }
                });
            }
        }

        OTPInput();
    });
</script>