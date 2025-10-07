@component('mail::message')
# Welcome to Bantayan 911 🚨

Hi **{{ $name }}**,  
Thank you for registering to **Bantayan 911** — your trusted emergency and community response system.

---

### 🔔 What's Next?
You can now:
- Report emergencies instantly  
- Stay updated with announcements  
- Connect directly with responders  

---

@component('mail::button', ['url' => 'https://bantayan-911.com'])
Go to Dashboard
@endcomponent

Stay safe,  
**The Bantayan 911 Team**

@endcomponent
