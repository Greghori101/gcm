<?php

return [
    'accepted'             => 'يجب قبول الحقل :attribute.',
    'accepted_if'          => 'يجب قبول الحقل :attribute عندما يكون :other بقيمة :value.',
    'active_url'           => 'الحقل :attribute لا يُمثّل رابطًا صحيحًا.',
    'after'                => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا للتاريخ :date.',
    'after_or_equal'       => 'يجب على الحقل :attribute أن يكون تاريخًا لاحقًا أو مطابقًا للتاريخ :date.',
    'alpha'                => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف.',
    'alpha_dash'           => 'يجب أن لا يحتوي الحقل :attribute سوى على حروف، أرقام ومطّات.',
    'alpha_num'            => 'يجب أن يحتوي الحقل :attribute على حروفٍ وأرقامٍ فقط.',
    'array'                => 'يجب أن يكون الحقل :attribute مصفوفة.',
    'ascii'                => 'يجب أن يحتوي الحقل :attribute على رموز وحروف لاتينية فقط.',
    'before'               => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا للتاريخ :date.',
    'before_or_equal'      => 'يجب على الحقل :attribute أن يكون تاريخًا سابقًا أو مطابقًا للتاريخ :date.',
    'between'              => [
        'array'   => 'يجب أن يحتوي الحقل :attribute على عدد من العناصر بين :min و :max.',
        'file'    => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute بين :min و :max.',
        'string'  => 'يجب أن يكون عدد حروف النّص :attribute بين :min و :max.',
    ],
    'boolean'              => 'يجب أن تكون قيمة الحقل :attribute إما true أو false .',
    'can'                  => 'يحتوي الحقل :attribute على قيمة غير مصرح بها.',
    'confirmed'            => 'حقل التأكيد غير مُطابق للحقل :attribute.',
    'contains'             => 'الحقل :attribute يجب أن يحتوي على قيمة مطلوبة.',
    'current_password'     => 'كلمة المرور غير صحيحة.',
    'date'                 => 'الحقل :attribute ليس تاريخًا صحيحًا.',
    'date_equals'          => 'يجب أن يكون الحقل :attribute مطابقًا للتاريخ :date.',
    'date_format'          => 'لا يتوافق الحقل :attribute مع الشكل :format.',
    'decimal'              => 'يجب أن يحتوي الحقل :attribute على :decimal منازل عشرية.',
    'declined'             => 'يجب رفض الحقل :attribute.',
    'declined_if'          => 'يجب رفض الحقل :attribute عندما يكون :other بقيمة :value.',
    'different'            => 'يجب أن يكون الحقل :attribute مُختلفًا عن الحقل :other.',
    'digits'               => 'يجب أن يحتوي الحقل :attribute على :digits رقمًا/أرقام.',
    'digits_between'       => 'يجب أن يحتوي الحقل :attribute بين :min و :max رقمًا/أرقام.',
    'dimensions'           => 'الحقول :attribute تحتوي على أبعاد صورة غير صالحة.',
    'distinct'             => 'للحقل :attribute قيمة مُكرّرة.',
    'doesnt_end_with'      => 'الحقل :attribute يجب ألا ينتهي بأحد القيم التالية: :values.',
    'doesnt_start_with'    => 'الحقل :attribute يجب ألا يبدأ بأحد القيم التالية: :values.',
    'email'                => 'يجب أن يكون الحقل :attribute عنوان بريد إلكتروني صحيح البُنية.',
    'ends_with'            => 'يجب أن ينتهي الحقل :attribute بأحد القيم التالية: :values.',
    'enum'                 => 'الحقل :attribute المختار غير صالح.',
    'exists'               => 'الحقل :attribute المختار غير صالح.',
    'extensions'           => 'يجب أن يحتوي الحقل :attribute على أحد الامتدادات التالية: :values.',
    'file'                 => 'الملف :attribute غير صالح.',
    'filled'               => 'الحقل :attribute إجباري.',
    'gt'                   => [
        'array'   => 'يجب أن يحتوي الحقل :attribute على أكثر من :value عناصر/عنصر.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من :value.',
        'string'  => 'يجب أن يكون طول نص :attribute أكثر من :value حروفٍ/حرفًا.',
    ],
    'gte'                  => [
        'array'   => 'يجب أن يحتوي الحقل :attribute على الأقل على :value عُنصرًا/عناصر.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أكبر من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول نص :attribute أكبر من أو يساوي :value حروفٍ/حرفًا.',
    ],
    'hex_color'            => 'الحقل :attribute يجب أن يكون لونًا سداسيًا صحيحًا.',
    'image'                => 'يجب أن يكون الحقل :attribute صورة.',
    'in'                   => 'الحقل :attribute المختار غير صالح.',
    'in_array'             => 'الحقل :attribute غير موجود في :other.',
    'integer'              => 'يجب أن يكون الحقل :attribute عددًا صحيحًا.',
    'ip'                   => 'يجب أن يكون الحقل :attribute عنوان IP صحيحًا.',
    'ipv4'                 => 'يجب أن يكون الحقل :attribute عنوان IPv4 صحيحًا.',
    'ipv6'                 => 'يجب أن يكون الحقل :attribute عنوان IPv6 صحيحًا.',
    'json'                 => 'يجب أن يكون الحقل :attribute نصًا من نوع JSON.',
    'list'                 => 'يجب أن يكون الحقل :attribute قائمة.',
    'lowercase'            => 'يجب أن يكون الحقل :attribute بأحرف صغيرة.',
    'lt'                   => [
        'array'   => 'يجب أن يحتوي الحقل :attribute على أقل من :value عناصر/عنصر.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أقل من :value.',
        'string'  => 'يجب أن يكون طول نص :attribute أقل من :value حروفٍ/حرفًا.',
    ],
    'lte'                  => [
        'array'   => 'يجب ألا يحتوي الحقل :attribute على أكثر من :value عناصر/عنصر.',
        'file'    => 'يجب أن يكون حجم الملف :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أقل من أو تساوي :value.',
        'string'  => 'يجب أن يكون طول نص :attribute أقل من أو يساوي :value حروفٍ/حرفًا.',
    ],
    'mac_address'          => 'الحقل :attribute يجب أن يكون عنوان MAC صحيح.',
    'max'                  => [
        'array'   => 'يجب ألا يحتوي الحقل :attribute على أكثر من :max عناصر/عنصر.',
        'file'    => 'يجب ألا يتجاوز حجم الملف :attribute :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة الحقل :attribute أقل من أو تساوي :max.',
        'string'  => 'يجب ألا يتجاوز طول نص :attribute :max حروفٍ/حرفًا.',
    ],
    // ...existing code...
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute field must have at least :min items.',
        'file' => 'The :attribute field must be at least :min kilobytes.',
        'numeric' => 'The :attribute field must be at least :min.',
        'string' => 'The :attribute field must be at least :min characters.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'The :attribute field must be a number.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_if_accepted' => 'The :attribute field is prohibited when :other is accepted.',
    'prohibited_if_declined' => 'The :attribute field is prohibited when :other is declined.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'array' => 'The :attribute field must contain :size items.',
        'file' => 'The :attribute field must be :size kilobytes.',
        'numeric' => 'The :attribute field must be :size.',
        'string' => 'The :attribute field must be :size characters.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string' => 'The :attribute field must be a string.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
