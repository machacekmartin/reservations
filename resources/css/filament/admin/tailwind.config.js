import preset from '../../../../vendor/filament/filament/tailwind.config.preset'

export default {
    presets: [preset],
    content: [
        './app/Filament/**/*.php',
        './app/Livewire/**/*.php',
        './resources/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
}
