<?php

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Student::insert([
            [
                'name' => 'tara',
                'image_name' => 'logo-tara.png',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse et nibh facilisis, accumsan tellus id, imperdiet nisl. Quisque ac est purus. Sed tempus venenatis maximus. Donec posuere ex sit amet quam accumsan, et semper purus efficitur. Donec ut ante in lacus faucibus dignissim at commodo lorem. Phasellus id neque orci. Fusce tempus erat justo, vel fringilla leo efficitur sed. Pellentesque non condimentum ligula. Praesent placerat, arcu vel elementum scelerisque, turpis urna tincidunt massa, malesuada aliquet lectus augue ac sem. Aenean vehicula quam augue, in pellentesque enim tincidunt dictum. Pellentesque vulputate lacus vitae dolor sollicitudin pellentesque.

Vestibulum ligula nibh, volutpat eget sodales vitae, ullamcorper vel risus. Aliquam risus velit, accumsan tincidunt eros ullamcorper, volutpat egestas diam. Aliquam erat volutpat. Morbi iaculis sem elementum leo sollicitudin, vitae sagittis neque facilisis. Vivamus consequat, odio ac sagittis varius, libero turpis pulvinar lorem, quis tempor lorem urna condimentum elit. Pellentesque vestibulum luctus ex nec scelerisque. Donec aliquet ut neque eget egestas. In cursus enim a sem vehicula, sit amet sollicitudin lacus lacinia. Nam interdum mi vel nisl viverra accumsan. Duis porta, ligula at venenatis condimentum, tellus quam dapibus quam, eget elementum nulla nisl nec mi. Integer scelerisque interdum risus, fringilla pulvinar libero rutrum gravida. Curabitur odio tortor, mollis in pharetra id, viverra eu ante. Nullam nec nulla mi. Integer mollis pellentesque gravida. Sed felis quam, luctus at est vitae, suscipit egestas nisi.

Aenean at est tristique, commodo dui quis, venenatis tellus. Aenean mattis maximus mi sit amet facilisis. Sed vel nibh sed metus finibus placerat. Praesent aliquam est eu est ultricies, vel aliquam dolor vulputate. Nam auctor justo eget mauris bibendum iaculis. Curabitur sodales dui non turpis aliquet, eu ultricies sapien mattis. Suspendisse aliquet nulla ut imperdiet varius. Phasellus laoreet mi augue, a lobortis elit sodales placerat. Donec rhoncus nulla ac risus eleifend, non semper ex vehicula. In hac habitasse platea dictumst. Vestibulum ut blandit arcu. Aenean efficitur varius porta. Suspendisse elit erat, dapibus vehicula maximus at, lobortis a eros. '
            ],

        ]);
    }
}
