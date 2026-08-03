@extends('admin.layouts.app')

@section('title', 'Mi Perfil')
@section('page-title', 'Mi Perfil')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/profile.css') }}">
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════
     HEADER COMPACT
     ═══════════════════════════════════════════════════ --}}
<div class="admin-compact-header" style="margin-bottom: 1.5rem;">
    <div class="admin-compact-header-left">
        <a href="{{ route('admin.dashboard') }}" class="admin-compact-header-back" title="Volver al Dashboard">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="admin-compact-header-info">
            <h1>
                <i class="fa-solid fa-user-gear"></i>
                Perfil: {{ $user->name }}
                <span class="admin-compact-header-status active">Administrador</span>
                @if($user->position)
                    <span class="admin-badge admin-badge-blue" style="margin-left: 0.5rem; font-size: 0.7rem; display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 12px; font-weight: 600;">
                        <i class="fa-solid fa-briefcase" style="font-size: 0.65rem;"></i> {{ $user->position }}
                    </span>
                @endif
            </h1>
        </div>
    </div>
    <div class="admin-compact-header-actions">
        <a href="{{ route('admin.dashboard') }}" class="admin-btn admin-btn-secondary" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.8rem; border-radius: 8px;">
            <i class="fa-solid fa-gauge"></i>
            <span>Dashboard</span>
        </a>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════
     MAIN CONTENT
     ═══════════════════════════════════════════════════ --}}
<div class="admin-profile-container">
    {{-- Left Column: Forms --}}
    <div class="admin-profile-main">
        {{-- Avatar Upload --}}
        <div class="admin-profile-card">
            <div class="admin-profile-card-header">
                <div class="admin-profile-card-header-left">
                    <i class="fa-solid fa-image"></i>
                    <div>
                        <h2 class="admin-profile-card-title">Foto de Perfil</h2>
                        <p class="admin-profile-card-subtitle">Sube una foto para personalizar tu perfil</p>
                    </div>
                </div>
            </div>
            <div class="admin-profile-card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data" id="avatarForm">
                    @csrf
                    @method('PUT')

                    {{-- Hidden fields to preserve user data --}}
                    <input type="hidden" name="name" value="{{ $user->name }}">
                    <input type="hidden" name="email" value="{{ $user->email }}">

                    <div class="admin-avatar-upload-container">
                        <div class="admin-avatar-preview">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" id="avatarPreview">
                            @else
                                <div class="admin-avatar-placeholder" id="avatarPlaceholder">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="admin-avatar-upload-info">
                            <h3 class="admin-avatar-upload-title">Cambiar foto de perfil</h3>
                            <p class="admin-avatar-upload-text">JPG, PNG o GIF. Tamaño máximo 50MB.</p>
                            <div class="admin-avatar-upload-actions">
                                <label for="avatar" class="admin-btn admin-btn-primary admin-btn-sm">
                                    <i class="fa-solid fa-upload"></i>
                                    Subir Foto
                                </label>
                                <input type="file"
                                       id="avatar"
                                       name="avatar"
                                       accept="image/*"
                                       class="admin-file-input"
                                       onchange="previewAvatar(event)">
                                @if($user->avatar)
                                <button type="button" class="admin-btn admin-btn-danger admin-btn-sm" onclick="deleteAvatar()">
                                    <i class="fa-solid fa-trash"></i>
                                    Eliminar
                                </button>
                                @endif
                            </div>
                            @error('avatar')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-profile-card-footer" id="avatarFormFooter" style="display: none;">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar Foto
                        </button>
                        <button type="button" class="admin-btn admin-btn-secondary" onclick="cancelAvatarUpload()">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Personal Information --}}
        <div class="admin-profile-card">
            <div class="admin-profile-card-header">
                <div class="admin-profile-card-header-left">
                    <i class="fa-solid fa-user"></i>
                    <div>
                        <h2 class="admin-profile-card-title">Información Personal</h2>
                        <p class="admin-profile-card-subtitle">Actualiza tu información básica</p>
                    </div>
                </div>
            </div>
            <div class="admin-profile-card-body">
                <form method="POST" action="{{ route('admin.profile.update') }}" id="profileForm">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-user"></i>
                                Nombre completo
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   class="admin-form-input"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   placeholder="Tu nombre completo">
                            @error('name')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-envelope"></i>
                                Correo electrónico
                                <span class="required">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   class="admin-form-input"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   placeholder="tu@email.com">
                            @error('email')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-briefcase"></i>
                                Cargo en la empresa
                            </label>
                            <input type="text"
                                   name="position"
                                   class="admin-form-input"
                                   value="{{ old('position', $user->position) }}"
                                   placeholder="Ej: Director de Marketing">
                            @error('position')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-phone"></i>
                                Teléfono
                            </label>
                            <input type="tel"
                                   name="phone"
                                   class="admin-form-input"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="+34 600 000 000">
                            @error('phone')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">
                            <i class="fa-solid fa-align-left"></i>
                            Biografía
                        </label>
                        <textarea name="bio"
                                  class="admin-form-textarea"
                                  rows="4"
                                  maxlength="500"
                                  placeholder="Cuéntanos un poco sobre ti...">{{ old('bio', $user->bio) }}</textarea>
                        <p class="admin-form-help">
                            <span id="bioCount">{{ strlen(old('bio', $user->bio ?? '')) }}</span> / 500 caracteres
                        </p>
                        @error('bio')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-row">
                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-location-dot"></i>
                                Ubicación
                            </label>
                            <input type="text"
                                   name="location"
                                   class="admin-form-input"
                                   value="{{ old('location', $user->location) }}"
                                   placeholder="Ciudad, País">
                            @error('location')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="admin-form-group">
                            <label class="admin-form-label">
                                <i class="fa-solid fa-globe"></i>
                                Sitio web
                            </label>
                            <input type="url"
                                   name="website"
                                   class="admin-form-input"
                                   value="{{ old('website', $user->website) }}"
                                   placeholder="https://tusitio.com">
                            @error('website')
                                <span class="admin-form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="admin-profile-card-footer">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="admin-profile-card">
            <div class="admin-profile-card-header">
                <div class="admin-profile-card-header-left">
                    <i class="fa-solid fa-key"></i>
                    <div>
                        <h2 class="admin-profile-card-title">Cambiar Contraseña</h2>
                        <p class="admin-profile-card-subtitle">Actualiza tu contraseña de acceso</p>
                    </div>
                </div>
            </div>
            <div class="admin-profile-card-body">
                <form method="POST" action="{{ route('admin.profile.password') }}" id="passwordForm">
                    @csrf
                    @method('PUT')

                    <div class="admin-form-group">
                        <label class="admin-form-label">
                            <i class="fa-solid fa-lock"></i>
                            Contraseña actual
                            <span class="required">*</span>
                        </label>
                        <div class="admin-password-input-group">
                            <input type="password"
                                   name="current_password"
                                   id="currentPassword"
                                   class="admin-form-input"
                                   required
                                   placeholder="Tu contraseña actual">
                            <button type="button" class="admin-password-toggle" onclick="togglePassword('currentPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">
                            <i class="fa-solid fa-lock"></i>
                            Nueva contraseña
                            <span class="required">*</span>
                        </label>
                        <div class="admin-password-input-group">
                            <input type="password"
                                   name="password"
                                   id="newPassword"
                                   class="admin-form-input"
                                   required
                                   placeholder="Mínimo 8 caracteres">
                            <button type="button" class="admin-password-toggle" onclick="togglePassword('newPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="admin-form-error">{{ $message }}</span>
                        @enderror
                        <div class="admin-password-strength" id="passwordStrength">
                            <div class="admin-password-strength-bar">
                                <div class="admin-password-strength-fill" id="passwordStrengthFill"></div>
                            </div>
                            <span class="admin-password-strength-text" id="passwordStrengthText">Ingresa una contraseña</span>
                        </div>
                    </div>

                    <div class="admin-form-group">
                        <label class="admin-form-label">
                            <i class="fa-solid fa-lock"></i>
                            Confirmar nueva contraseña
                            <span class="required">*</span>
                        </label>
                        <div class="admin-password-input-group">
                            <input type="password"
                                   name="password_confirmation"
                                   id="confirmPassword"
                                   class="admin-form-input"
                                   required
                                   placeholder="Repite la nueva contraseña">
                            <button type="button" class="admin-password-toggle" onclick="togglePassword('confirmPassword', this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="admin-profile-card-footer">
                        <button type="submit" class="admin-btn admin-btn-primary">
                            <i class="fa-solid fa-key"></i>
                            Actualizar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right Column: Info Cards --}}
    <div class="admin-profile-sidebar">
        {{-- Account Stats --}}
        <div class="admin-profile-sidebar-card">
            <h3 class="admin-profile-sidebar-title">
                <i class="fa-solid fa-chart-simple"></i>
                Estadísticas de Cuenta
            </h3>
            <div class="admin-profile-stats">
                <div class="admin-profile-stat">
                    <div class="admin-profile-stat-icon admin-profile-stat-icon--primary">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    <div class="admin-profile-stat-content">
                        <span class="admin-profile-stat-value">{{ $user->posts()->count() }}</span>
                        <span class="admin-profile-stat-label">Posts Creados</span>
                    </div>
                </div>
                <div class="admin-profile-stat">
                    <div class="admin-profile-stat-icon admin-profile-stat-icon--success">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="admin-profile-stat-content">
                        <span class="admin-profile-stat-value">{{ $user->created_at->diffInDays(now()) }}</span>
                        <span class="admin-profile-stat-label">Días Activo</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Tips --}}
        <div class="admin-profile-sidebar-card admin-profile-tips">
            <h3 class="admin-profile-sidebar-title">
                <i class="fa-solid fa-shield-halved"></i>
                Consejos de Seguridad
            </h3>
            <ul class="admin-tips-list">
                <li>
                    <i class="fa-solid fa-check"></i>
                    Usa una contraseña fuerte y única
                </li>
                <li>
                    <i class="fa-solid fa-check"></i>
                    Cambia tu contraseña regularmente
                </li>
                <li>
                    <i class="fa-solid fa-check"></i>
                    No compartas tus credenciales
                </li>
                <li>
                    <i class="fa-solid fa-check"></i>
                    Cierra sesión en dispositivos públicos
                </li>
            </ul>
        </div>

        {{-- Account Info --}}
        <div class="admin-profile-sidebar-card">
            <h3 class="admin-profile-sidebar-title">
                <i class="fa-solid fa-info-circle"></i>
                Información de Cuenta
            </h3>
            <div class="admin-profile-info">
                <div class="admin-profile-info-item">
                    <span class="admin-profile-info-label">ID de Usuario</span>
                    <span class="admin-profile-info-value">#{{ $user->id }}</span>
                </div>
                <div class="admin-profile-info-item">
                    <span class="admin-profile-info-label">Cuenta Creada</span>
                    <span class="admin-profile-info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="admin-profile-info-item">
                    <span class="admin-profile-info-label">Última Actualización</span>
                    <span class="admin-profile-info-value">{{ $user->updated_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="admin-profile-info-item">
                    <span class="admin-profile-info-label">Rol</span>
                    <span class="admin-profile-info-value">
                        <span class="admin-profile-role-badge">
                            <i class="fa-solid fa-crown"></i>
                            Administrador
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden form for avatar deletion --}}
<form id="deleteAvatarForm" method="POST" action="{{ route('admin.profile.avatar.delete') }}" style="display: none;">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
// Avatar preview
function previewAvatar(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            const placeholder = document.getElementById('avatarPlaceholder');
            
            if (preview) {
                preview.src = e.target.result;
            } else if (placeholder) {
                placeholder.outerHTML = `<img src="${e.target.result}" alt="Preview" id="avatarPreview">`;
            }
            
            // Show save button
            document.getElementById('avatarFormFooter').style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }
}

// Cancel avatar upload
function cancelAvatarUpload() {
    document.getElementById('avatar').value = '';
    document.getElementById('avatarFormFooter').style.display = 'none';
    location.reload();
}

// Delete avatar
async function deleteAvatar() {
    if (confirm('¿Estás seguro de que quieres eliminar tu foto de perfil?')) {
        document.getElementById('deleteAvatarForm').submit();
    }
}

// Toggle password visibility
function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password strength checker
const newPasswordInput = document.getElementById('newPassword');
const strengthFill = document.getElementById('passwordStrengthFill');
const strengthText = document.getElementById('passwordStrengthText');

if (newPasswordInput) {
    newPasswordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let text = '';
        let color = '';

        if (password.length === 0) {
            strength = 0;
            text = 'Ingresa una contraseña';
            color = '#e2e8f0';
        } else if (password.length < 6) {
            strength = 25;
            text = 'Muy débil';
            color = '#ef4444';
        } else if (password.length < 8) {
            strength = 50;
            text = 'Débil';
            color = '#f59e0b';
        } else {
            strength = 75;
            text = 'Buena';
            color = '#10b981';

            // Check for strong password
            const hasUpperCase = /[A-Z]/.test(password);
            const hasLowerCase = /[a-z]/.test(password);
            const hasNumbers = /\d/.test(password);
            const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

            if (hasUpperCase && hasLowerCase && hasNumbers && hasSpecialChar && password.length >= 12) {
                strength = 100;
                text = 'Muy fuerte';
                color = '#059669';
            }
        }

        strengthFill.style.width = strength + '%';
        strengthFill.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
}

// Bio character counter
const bioTextarea = document.querySelector('textarea[name="bio"]');
const bioCount = document.getElementById('bioCount');

if (bioTextarea) {
    bioTextarea.addEventListener('input', function() {
        bioCount.textContent = this.value.length;
    });
}
</script>
@endpush
