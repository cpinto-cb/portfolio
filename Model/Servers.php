<?php
/**
 * Created by PhpStorm.
 * User: Chris
 * Date: 12/20/14
 * Time: 9:12 PM
 */

namespace Model;
/**
 *
 * @Entity
 *
 * @Table(name="servers", indexes={@Index(name="name_idx", columns={"name"}),
 *                                 @Index(name="type_idx", columns={"type"}),
 *                                 @Index(name="status_idx", columns={"status"}),
 *                                 @Index(name="az_idx", columns={"az"}),
 *                                 @Index(name="public_idx", columns={"public_ip_address"}),
 *                                 @Index(name="private_idx", columns={"private_ip_address"})
 *                                }
 *       )
 *
 */

class Servers {

    /**
     *
     * @Id
     * @Column(name="id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * @var  int $id
     *
     */
    private $id;

    /**
     *
     * @Column(name="server_id", type="string", length=64, unique=true)
     *
     * @var  string $server_id
     *
     */
    private $server_id;


    /**
     *
     * @Column(name="name", type="string", length=64)
     * @Index(name="name_idx", columns={"name"})
     * @var  string $name
     */
    private $name;

    /**
     *
     * @Column(name="type", type="string", length=32, unique=false)
     *
     * @var  string $type
     */


    private $type;


    /**
     *
     * @Column(name="status", type="string", length=64, unique=false)
     * @var  string $status
     */
    private $status;

    /**
     *
     * @Column(name="az", type="string", length=64, unique=false)
     *
     * @var  string $az
     */


    private $az;


    /**
     *
     * @Column(name="public_ip_address", type="string", length=11, unique=false)
     *
     */
    private $public_ip_address;

    /**
     *
     * @Column(name="private_ip_address", type="string", length=11, unique=false)
     *
     */
    private $private_ip_address;

    /**
     * @param string $az
     */
    public function setAz($az)
    {
        $this->az = $az;
    }

    /**
     * @return string
     */
    public function getAz()
    {
        return $this->az;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $private_ip_address
     */
    public function setPrivateIpAddress($private_ip_address)
    {
        $this->private_ip_address = $private_ip_address;
    }

    /**
     * @return mixed
     */
    public function getPrivateIpAddress()
    {
        return $this->private_ip_address;
    }

    /**
     * @param mixed $public_ip_address
     */
    public function setPublicIpAddress($public_ip_address)
    {
        $this->public_ip_address = $public_ip_address;
    }

    /**
     * @return mixed
     */
    public function getPublicIpAddress()
    {
        return $this->public_ip_address;
    }

    /**
     * @param string $server_id
     */
    public function setServerId($server_id)
    {
        $this->server_id = $server_id;
    }

    /**
     * @return string
     */
    public function getServerId()
    {
        return $this->server_id;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }



} 