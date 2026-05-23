<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            {{ $availableLocales[$currentLocale] ?? 'Language' }}
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            @foreach($availableLocales as $locale => $name)
                <li>
                    <a class="dropdown-item {{ $locale === $currentLocale ? 'active' : '' }}" 
                       href="{{ route('language.switch', $locale) }}">
                        {{ $name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

<style>
.language-switcher .dropdown-toggle::after {
    margin-left: 0.5em;
}

.language-switcher .dropdown-item.active {
    background-color: #0d6efd;
    color: white;
}

.language-switcher .dropdown-item:hover {
    background-color: #f8f9fa;
}
</style>
