@component('mail::message')
# New Contact Message

**Name:** {{ $data['name'] }}  
**Email:** {{ $data['email'] }}  
**Phone:** {{ $data['phone'] ?? 'N/A' }}  
**Subject:** {{ $data['subject'] ?? 'N/A' }}

**Message:**  
{{ $data['message'] }}

@endcomponent
