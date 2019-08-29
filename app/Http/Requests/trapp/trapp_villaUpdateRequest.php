<?php

namespace App\Http\Requests\trapp;

use App\Http\Requests\sweetRequest;

class trapp_villaUpdateRequest extends sweetRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $Fields = [
            'roomcountnum' => 'required|numeric',
            'capacitynum' => 'required|numeric',
            'maxguestsnum' => 'required|numeric',
            'structureareanum' => 'required|numeric',
            'totalareanum' => 'required|numeric',
            'viewtype' => 'required|min:-1|integer',
            'structuretype' => 'required|min:-1|integer',
            'fulltimeservice' => 'required',
            'timestartclk' => 'required',
            'owningtype' => 'required|min:-1|integer',
            'areatype' => 'required|min:-1|integer',
            'normalpriceprc' => 'required|numeric',
            'holidaypriceprc' => 'required|numeric',
            'weeklyoffnum' => 'required|numeric',
            'monthlyoffnum' => 'required|numeric',
        ];
        return $Fields;
    }

    public function messages()
    {
        return [

            'roomcountnum.required' => 'وارد کردن تعداد اتاق اجباری می باشد',
            'roomcountnum.numeric' => 'مقدار تعداد اتاق باید عدد انگلیسی باشد.',
            'capacitynum.required' => 'وارد کردن ظرفیت به نفر اجباری می باشد',
            'capacitynum.numeric' => 'مقدار ظرفیت به نفر باید عدد انگلیسی باشد.',
            'maxguestsnum.required' => 'وارد کردن حداکثر تعداد مهمان اجباری می باشد',
            'maxguestsnum.numeric' => 'مقدار حداکثر تعداد مهمان باید عدد انگلیسی باشد.',
            'structureareanum.required' => 'وارد کردن متراژ بنا اجباری می باشد',
            'structureareanum.numeric' => 'مقدار متراژ بنا باید عدد انگلیسی باشد.',
            'totalareanum.required' => 'وارد کردن متراژ کل اجباری می باشد',
            'totalareanum.numeric' => 'مقدار متراژ کل باید عدد انگلیسی باشد.',
            'placemanplace.required' => 'وارد کردن محل اجباری می باشد',
            'placemanplace.integer' => 'مقدار محل صحیح وارد نشده است.',
            'addedbyowner.required' => 'وارد کردن دارای سند مالکیت به نام کاربر اجباری می باشد',
            'viewtype.required' => 'وارد کردن چشم انداز اجباری می باشد',
            'viewtype.integer' => 'مقدار چشم انداز صحیح وارد نشده است.',
            'structuretype.required' => 'وارد کردن نوع ساختمان اجباری می باشد',
            'structuretype.integer' => 'مقدار نوع ساختمان صحیح وارد نشده است.',
            'fulltimeservice.required' => 'وارد کردن تحویل ۲۴ ساعته اجباری می باشد',
            'timestartclk.required' => 'وارد کردن زمان تحویل/تخلیه اجباری می باشد',
            'owningtype.required' => 'وارد کردن نوع اقامتگاه اجباری می باشد',
            'owningtype.integer' => 'مقدار نوع اقامتگاه صحیح وارد نشده است.',
            'areatype.required' => 'وارد کردن بافت اجباری می باشد',
            'areatype.integer' => 'مقدار بافت صحیح وارد نشده است.',
            'descriptionte.required' => 'وارد کردن توضیحات اجباری می باشد',
            'documentphotoigu.required' => 'وارد کردن سند مالکیت اجباری می باشد',
            'normalpriceprc.required' => 'وارد کردن قیمت در روزهای عادی اجباری می باشد',
            'normalpriceprc.numeric' => 'مقدار قیمت در روزهای عادی باید عدد انگلیسی باشد.',
            'holidaypriceprc.required' => 'وارد کردن قیمت در روزهای تعطیل اجباری می باشد',
            'holidaypriceprc.numeric' => 'مقدار قیمت در روزهای تعطیل باید عدد انگلیسی باشد.',
            'weeklyoffnum.required' => 'وارد کردن تخفیف رزرو بیش از یک هفته اجباری می باشد',
            'weeklyoffnum.numeric' => 'مقدار تخفیف رزرو بیش از یک هفته باید عدد انگلیسی باشد.',
            'monthlyoffnum.required' => 'وارد کردن تخفیف رزرو بیش از یک ماه اجباری می باشد',
            'monthlyoffnum.numeric' => 'مقدار تخفیف رزرو بیش از یک ماه باید عدد انگلیسی باشد.',
        ];
    }
}