<?php
namespace App\Exports;

use App\UsoPuerta;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;

class UsoPuertaExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $fechaInicio;
    protected $fechaFin;
    protected $contrato;

    public function __construct($fechaInicio, $fechaFin, $contrato)
    {
        $this->fechaInicio = $fechaInicio;
        $this->fechaFin = $fechaFin;
        $this->contrato = $contrato;
    }

    public function query()
    {
        $query = UsoPuerta::query()
            ->join('empleados', 'uso_puerta.IdEmpleado', '=', 'empleados.id')
            ->join('puertas', 'uso_puerta.IdPuerta', '=', 'puertas.id');

        if ($this->fechaInicio) {
            $query->where('Fecha', '>=', Carbon::parse($this->fechaInicio)->startOfDay());
        }

        if ($this->fechaFin) {
            $query->where('Fecha', '<=', Carbon::parse($this->fechaFin)->endOfDay());
        }

        if ($this->contrato) {
            $query->where('empleados.NoContrato', $this->contrato);
        }

        return $query->select(
            'empleados.Nombre',
            'empleados.ApellidoP',
            'empleados.ApellidoM',
            'empleados.NoContrato',
            'puertas.NombrePuerta',
            'puertas.Tipo',
            'uso_puerta.Fecha',
            'uso_puerta.latitude',
            'uso_puerta.longitud',
            'uso_puerta.img'
        );
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Apellido Paterno',
            'Apellido Materno',
            'Contrato',
            'Puerta',
            'Tipo',
            'Fecha y Hora',
            'Latitud',
            'Longitud',
            'URL de la Imagen',
            'URL de Google Maps'
        ];
    }

    public function map($usoPuerta): array
    {
        $googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' . $usoPuerta->latitude . ',' . $usoPuerta->longitud;

        return [
            $usoPuerta->Nombre,
            $usoPuerta->ApellidoP,
            $usoPuerta->ApellidoM,
            $usoPuerta->NoContrato,
            $usoPuerta->NombrePuerta,
            $usoPuerta->Tipo,
            $usoPuerta->Fecha,
            $usoPuerta->latitude,
            $usoPuerta->longitud,
            asset('https://pactral.com/PuntoAcceso/public/' . $usoPuerta->img),
            $googleMapsUrl
        ];
    }
}

