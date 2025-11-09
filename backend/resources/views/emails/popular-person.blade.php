<x-mail::message>
# 🎉 {{ $person->name }} is on fire!

{{ $person->name }} just crossed **{{ $person->likes_count }} likes** on HyperSwipe.

Keep an eye on them—they might need a special highlight or promo push.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
