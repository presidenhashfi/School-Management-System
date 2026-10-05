<div class="sf-main-card">
    <form action="{{ $action }}" method="POST" id="sfForm">
        @csrf
        @if(isset($user)) @method('PUT') @endif
        <div class="sf-sec-hdr">
            <div class="sf-sec-num">1</div>
            <div class="sf-sec-title">Data Akun</div>
            <div class="sf-sec-line"></div>
        </div>
        <div class="sf-fields">
            <div class="sf-grid2">
                <div class="sf-field">
                    <label for="username"><i class="bi bi-person"></i> Username <span class="req">*</span></label>
                    <input type="text" name="username" id="username" value="{{ old('username', $user->username ?? '') }}" maxlength="50" autofocus required>
                    @error('username')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="email"><i class="bi bi-envelope"></i> Email <span class="req">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" maxlength="100" required>
                    @error('email')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field" style="grid-column:1/-1;">
                    <label for="role"><i class="bi bi-shield-check"></i> Role <span class="req">*</span></label>
                    <select name="role" id="role" required>
                        @foreach($roles as $r)
                            <option value="{{ $r }}" @selected(old('role', $user->role ?? '') === $r)>{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                    @error('role')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="password"><i class="bi bi-key"></i> Password @unless(isset($user))<span class="req">*</span>@endunless</label>
                    <input type="password" name="password" id="password" minlength="6" autocomplete="new-password" placeholder="{{ isset($user) ? 'Kosongkan jika tidak diubah' : 'Minimal 6 karakter' }}" @unless(isset($user)) required @endunless>
                    @error('password')<div class="sf-error"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>@enderror
                </div>
                <div class="sf-field">
                    <label for="password_confirmation"><i class="bi bi-key-fill"></i> Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password" @unless(isset($user)) required @endunless>
                </div>
            </div>
        </div>
        <div class="sf-footer">
            <button type="submit" class="btn-sf btn-sf-submit"><i class="bi bi-floppy-fill"></i> Simpan Akun</button>
            <a href="{{ route('users.index') }}" class="btn-sf-cancel"><i class="bi bi-arrow-left"></i> Batal</a>
        </div>
    </form>
</div>
