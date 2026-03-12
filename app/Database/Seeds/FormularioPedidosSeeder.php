<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FormularioPedidosSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'idempresa' => 1,
                'idservicio' => 1,
                'titulo' => 'Afiche Graduacion Promocion 2025',
                'area' => 'Direccion Academica',
                'objetivo_comunicacion' => 'Comunicar el evento de graduacion de la promocion 2025 dirigido a estudiantes y docentes de la UAI',
                'descripcion' => 'Afiche para ceremonia de graduacion. Titulo: Ceremonia de Graduacion UAI 2025. Fecha: 15 de Abril 2026. Hora: 6:00 pm. Lugar: Auditorio Principal UAI. Incluir logo UAI y colores institucionales.',
                'tipo_requerimiento' => 'Creacion de Arte',
                'canales_difusion' => '["Redes sociales", "SIGU o Aula Virtual Estudiantes", "Banner físico"]',
                'publico_objetivo' => 'Estudiantes y docentes de la UAI. Tono formal e institucional.',
                'tiene_materiales' => true,
                'formatos_solicitados' => '["Afiche A4", "Post de Facebook/Instagram", "Historia Facebook/Instagram"]',
                'formato_otros' => null,
                'fecharequerida' => '2026-04-10 00:00:00',
                'prioridad' => 'alta',
            ],
            [
                'idempresa' => 2,  // Byron
                'idservicio' => 2,  // Audiovisual
                'titulo' => 'Video Promocional Matriculas 2026',
                'area' => 'Secretaria Academica',
                'objetivo_comunicacion' => 'Comunicar el proceso de matriculas 2026 a todos los alumnos nuevos e ingresantes del colegio Byron',
                'descripcion' => 'Video promocional proceso de matriculas. Titulo: Matriculas Abiertas 2026. Fecha inicio: 1 de Abril 2026. Fecha fin: 30 de Abril 2026. Lugar: Secretaria del Colegio Byron. Incluir logo institucional y colores del colegio.',
                'tipo_requerimiento' => 'Creacion de Video',
                'canales_difusion' => '["Redes sociales", "Historia de Whatsapp", "Página web"]',
                'publico_objetivo' => 'Padres de familia y alumnos ingresantes. Tono amigable y cercano.',
                'tiene_materiales' => false,
                'formatos_solicitados' => '["Reels de Facebook/Instagram", "Historia Facebook/Instagram", "Reel/Historia TikTok"]',
                'formato_otros' => null,
                'fecharequerida' => '2026-03-25 00:00:00',
                'prioridad' => 'media',
            ]
        ];

        $this->db->table('formulario_pedidos')->insertBatch($data);
    }
}
