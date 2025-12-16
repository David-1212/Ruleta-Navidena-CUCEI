<h1>👑 Super Admin</h1>

<h2>Usuarios</h2>
<table>
@foreach($usuarios as $u)
<tr>
<td>{{ $u->name }}</td>
<td>{{ $u->role }}</td>
</tr>
@endforeach
</table>

<h2>Premios</h2>
<table>
@foreach($premios as $p)
<tr>
<td>{{ $p->nombre }}</td>
<td>{{ $p->entregado ? 'Sí' : 'No' }}</td>
</tr>
@endforeach
</table>

<h2>Participantes</h2>
<table>
@foreach($participantes as $p)
<tr>
<td>{{ $p->nombre }}</td>
<td>{{ $p->ganador ? 'Sí' : 'No' }}</td>
</tr>
@endforeach
</table>
