<div _style="max-height: 800px;">
    <div class="bg-white py-16 sm:py-24">
        <div class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="relative">
                <div class="sm:text-center">
                    <h2 class="text-3xl font-extrabold text-gray-700 tracking-tight sm:text-4xl">
                        Get Random XKCD Comics
                    </h2>
                    <p class="mt-6 mx-auto max-w-2xl text-lg text-gray-600">
                        subscribe to get a random XKCD comics every five minutes through your email
                    </p>
                </div>
                <form action="" method="POST" class="mt-12 sm:mx-auto sm:max-w-lg">
                    <div class="sm:flex">
                        <div class="min-w-0 flex-1">
                            <label for="cta_email" class="sr-only">Email address</label>
                            <input id="cta_email" name="email" type="email" class="block w-full border rounded-md px-5 py-3 text-base text-gray-900 placeholder-gray-500 shadow-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600" placeholder="Enter your email">
                        </div>
                        <div class="mt-4 sm:mt-0 sm:ml-3">
                            <button type="submit" class="block w-full rounded-md border border-transparent px-5 py-3 bg-green-500 text-base font-medium text-white shadow hover:bg-green-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-green-600 sm:px-10">Subscribe</button>
                        </div>
                    </div>
                    <?php if (!$data["is_valid_email"]) echo "<p class='text-red-500 mt-2'>please enter a valid email</p>" ?>
                </form>
            </div>
        </div>
    </div>
</div>