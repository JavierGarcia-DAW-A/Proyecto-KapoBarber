$b1 = \App\Models\Barbers::find(1);
$b1->slug = 'guy-pulido'; $b1->save();
$u1 = \App\Models\User::find($b1->user_id);
if($u1) { $u1->email = 'guy-pulido@kapobarber.com'; $u1->save(); }

$b2 = \App\Models\Barbers::find(2);
$b2->slug = 'steve-nolan'; $b2->save();
$u2 = \App\Models\User::find($b2->user_id);
if($u2) { $u2->email = 'steve-nolan@kapobarber.com'; $u2->password = bcrypt('12345678'); $u2->save(); }

$b3 = \App\Models\Barbers::find(3);
$b3->slug = 'edgar-mathis'; $b3->save();
$u3 = \App\Models\User::find($b3->user_id);
if($u3) { $u3->email = 'edgar-mathis@kapobarber.com'; $u3->save(); }

echo "\nFixed slugs and emails!\n";
